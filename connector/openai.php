<?php

$enginePath = dirname((__FILE__)) . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
require_once($enginePath . "lib" .DIRECTORY_SEPARATOR."tokenizer_helper_functions.php");


class openai
{
    public $primary_handler;
    public $name;

    private $_functionName;
    private $_parameterBuff;
    private $_commandBuffer;
    private $_numOutputTokens;
    private $_dataSent;
    private $_fid;
    private $_stopProc;
    private $_buffer;


    public function __construct()
    {
        $this->name="openai";
        $this->_commandBuffer=[];
        $this->_stopProc=false;

    }


    public function open($contextData, $customParms)
    {
        $url = $GLOBALS["CONNECTOR"][$this->name]["url"];
        $b_groq = (strpos($url, "groq.com") > 0 ); // https://api.groq.com/openai/v1/chat/completions

        $MAX_TOKENS=((isset($GLOBALS["CONNECTOR"][$this->name]["max_tokens"]) ? $GLOBALS["CONNECTOR"][$this->name]["max_tokens"] : 48)+0);



        /***
            In the realm of perfection, the demand to tailor context for every language model would be nonexistent.

                                                                                                Tyler, 2023/11/09
        ****/
        
        if (isset($GLOBALS["FEATURES"]["MEMORY_EMBEDDING"]["ENABLED"]) && $GLOBALS["FEATURES"]["MEMORY_EMBEDDING"]["ENABLED"] && isset($GLOBALS["MEMORY_STATEMENT"]) ) {
            foreach ($contextData as $n=>$contextline)  {
                if (strpos($contextline["content"],"#MEMORY")===0) {
                    $contextData[$n]["content"]=str_replace("#MEMORY","##\nMEMORY\n",$contextline["content"]."\n##\n");
                } else if (strpos($contextline["content"],$GLOBALS["MEMORY_STATEMENT"])!==false) {
                    $contextData[$n]["content"]=str_replace($GLOBALS["MEMORY_STATEMENT"],"(USE MEMORY reference)",$contextline["content"]);
                }
            }
        }
        
        $contextDataOrig=array_values($contextData);
        $pb["user"]="";
        $pb["system"]=""; 
        foreach ($contextDataOrig as $n=>$element) {
            
            
            if ($n>=(sizeof($contextDataOrig)-2)) {
                // Last element
                $pb["user"].=$element["content"];
                
            } else {
                if ($element["role"]=="system") {
                    
                    $pb["system"]=$element["content"]."\nThis is the script history for this story\n#CONTEXT_HISTORY\n";
                    
                } else if ($element["role"]=="user") {
                    if (empty($element["content"])) {
                        unset($contextData[$n]);
                    }
                    
                    $pb["system"].=trim($element["content"])."\n";
                    
                } else if ($element["role"]=="assistant") {
                    
                    if (isset($element["tool_calls"])) {
                        $pb["system"].="{$GLOBALS["HERIKA_NAME"]} issued ACTION {$element["tool_calls"][0]["function"]["name"]}";
                        $lastAction="{$GLOBALS["HERIKA_NAME"]} issued ACTION {$element["tool_calls"][0]["function"]["name"]} {$element["tool_calls"][0]["function"]["arguments"]}";
                        
                        $localFuncCodeName=getFunctionCodeName($element["tool_calls"][0]["function"]["name"]);
                        $localArguments=json_decode($element["tool_calls"][0]["function"]["arguments"],true);
                        $lastAction=strtr($GLOBALS["F_RETURNMESSAGES"][$localFuncCodeName],[
                                        "#TARGET#"=>current($localArguments),
                                        ]);
                        
                        unset($contextData[$n]);
                    } else
                        $pb["system"].=$element["content"]."\n";
                    
                } else if ($element["role"]=="tool") {
                    
                     if (!empty($element["content"])) {
                            $pb["system"].=$element["content"]."\n";
                            if (strpos($element["content"],"Error")===false) {
                                $contextData[$n]=[
                                        "role"=>"user",
                                        "content"=>"The Narrator:".strtr($lastAction,["#RESULT#"=>$element["content"]]),
                                        
                                    ];
                                    
                                $GLOBALS["PATCH_STORE_FUNC_RES"]=strtr($lastAction,["#RESULT#"=>$element["content"]]);
                            } else {
                                $contextData[$n]=[
                                        "role"=>"user",
                                        "content"=>"The Narrator: NOTE, cannot go to that place:".current($localArguments),
                                        
                                ];
                            }
                        } else
                            unset($contextData[$n]);
                }
            }
        }
        
        $contextData2=[];
        $contextData2[]= ["role"=>"system","content"=>$pb["system"]];
        $contextData2[]= ["role"=>"user","content"=>$pb["user"]];
        
        
        // Compacting */
        $contextDataCopy=[];
        foreach ($contextData as $n=>$element) 
            if (!empty($element["content"]))
                $contextDataCopy[]=$element;
        
        $contextData=$contextDataCopy;
        

        if ($b_groq) { // --- exception made for groq.com
            // this sequence send only content chat completion
            
            $data = array( // different: max_tokens
                'model' => (isset($GLOBALS["CONNECTOR"][$this->name]["model"])) ? $GLOBALS["CONNECTOR"][$this->name]["model"] : 'llama-3.3-70b-versatile', // short lifespan
                'messages' => $contextData, // ok
                'stream' => true, // required for CHIM
                'max_tokens'=>$MAX_TOKENS,  //different
                'temperature' => ($GLOBALS["CONNECTOR"][$this->name]["temperature"]) ?: 1, 
                'top_p' => ($GLOBALS["CONNECTOR"][$this->name]["top_p"]) ?: 1, 
                'presence_penalty' => ($GLOBALS["CONNECTOR"][$this->name]["presence_penalty"]) ?: 0, 
                'frequency_penalty' => ($GLOBALS["CONNECTOR"][$this->name]["frequency_penalty"]) ?: 0 
            );

            unset($data["max_completion_tokens"]); //probably not needed now
            
            if (isset($customParms["MAX_TOKENS"])) {
                if ($customParms["MAX_TOKENS"]==0) {
                    unset($data["max_tokens"]); //different 
                } elseif (isset($customParms["MAX_TOKENS"])) {
                    $data["max_tokens"]=$customParms["MAX_TOKENS"]+0;
                }
            }

            if (isset($GLOBALS["FORCE_MAX_TOKENS"])) {
                if ($GLOBALS["FORCE_MAX_TOKENS"]==0) {
                    unset($data["max_tokens"]); //different
                } else
                    $data["max_tokens"]=$GLOBALS["FORCE_MAX_TOKENS"]+0;
            }

        } else { // --- normal flow (not groq)

            $data = array(
                'model' => (isset($GLOBALS["CONNECTOR"][$this->name]["model"])) ? $GLOBALS["CONNECTOR"][$this->name]["model"] : 'llama-3.3-70b-versatile',
                'messages' =>
                    $contextData,
                'stream' => true,
                'max_completion_tokens'=>$MAX_TOKENS,
                'temperature' => ($GLOBALS["CONNECTOR"][$this->name]["temperature"]) ?: 1,
                'top_p' => ($GLOBALS["CONNECTOR"][$this->name]["top_p"]) ?: 1,
            );
            // Mistral AI API does not support penalty params
            if (strpos($url, "mistral") === false) {
                $data["presence_penalty"]=($GLOBALS["CONNECTOR"][$this->name]["presence_penalty"]) ?: 0;
                $data["frequency_penalty"]=($GLOBALS["CONNECTOR"][$this->name]["frequency_penalty"]) ?: 0;
            }



            if (isset($customParms["MAX_TOKENS"])) {
                if ($customParms["MAX_TOKENS"]==0) {
                    unset($data["max_completion_tokens"]);
                } elseif (isset($customParms["MAX_TOKENS"])) {
                    $data["max_completion_tokens"]=$customParms["MAX_TOKENS"]+0;
                }
            }


            if (isset($GLOBALS["FORCE_MAX_TOKENS"])) {
                if ($GLOBALS["FORCE_MAX_TOKENS"]==0) {
                    unset($data["max_completion_tokens"]);
                } else
                    $data["max_completion_tokens"]=$GLOBALS["FORCE_MAX_TOKENS"]+0;
            }

            if (isset($GLOBALS["FUNCTIONS_ARE_ENABLED"]) && $GLOBALS["FUNCTIONS_ARE_ENABLED"]) {
                foreach ($GLOBALS["FUNCTIONS"] as $function)
                    $data["tools"][]=["type"=>"function","function"=>$function];
                if (isset($GLOBALS["FUNCTIONS_FORCE_CALL"])) {
                    $data["tool_choice"]=$GLOBALS["FUNCTIONS_FORCE_CALL"];
                }
            }

        } // --- endif groq

        if (isset($GLOBALS["CONNECTOR"][$this->name]["extra_parameters"]) && is_rray($GLOBALS["CONNECTOR"][$this->name]["extra_parameters"])) {
            foreach ($GLOBALS["CONNECTOR"][$this->name]["extra_parameters"] as $k=>$v) {
                $data[$k]=$v;

            }
        }

        $GLOBALS["DEBUG_DATA"]["full"]=($data);

        $headers = array(
            'Content-Type: application/json',
            "Authorization: Bearer {$GLOBALS["CONNECTOR"][$this->name]["API_KEY"]}"
        );

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $headers),
                'content' => json_encode($data),
                'timeout' => ($GLOBALS["HTTP_TIMEOUT"]) ?: 30
            )
        );

        $context = stream_context_create($options);

        file_put_contents(__DIR__."/../log/context_sent_to_llm.log",date(DATE_ATOM)."\n=\n".var_export($data,true)."\n=\n", FILE_APPEND);

                
        $this->primary_handler = fopen($url, 'r', false, $context);
        if (!$this->primary_handler) {
                error_log(print_r(error_get_last(),true));
                return null;
        }

        $this->_dataSent=json_encode($data);    // Will use this data in tokenizer.


        return true;


    }


    public function process()
    {
        global $alreadysent;

        static $numOutputTokens=0;

        $line = fgets($this->primary_handler);
        $buffer="";
        $totalBuffer="";

        file_put_contents(__DIR__."/../log/debugStream.log", $line, FILE_APPEND);

        $data=json_decode(substr($line, 6), true);
        if (isset($data["choices"][0]["delta"]["content"])) {
            if (strlen(($data["choices"][0]["delta"]["content"]))>0) {
                $buffer.=$data["choices"][0]["delta"]["content"];
                $this->_numOutputTokens += 1;
                $this->_buffer.=$buffer;

            }
            $totalBuffer.=$data["choices"][0]["delta"]["content"];

        }

       
        if (isset($data["choices"][0]["delta"]["tool_calls"])) {

        
            if (isset($data["choices"][0]["delta"]["tool_calls"][0]["function"]["name"])) {
                if (!isset($this->_functionName))
                    $this->_functionName = $data["choices"][0]["delta"]["tool_calls"][0]["function"]["name"];
                else
                    $this->_stopProc=true;
            }

            if (isset($data["choices"][0]["delta"]["tool_calls"][0]["function"]["arguments"])) {
                if (!$this->_stopProc)
                    $this->_parameterBuff .= $data["choices"][0]["delta"]["tool_calls"][0]["function"]["arguments"];

            }
            
            if (isset($data["choices"][0]["delta"]["tool_calls"][0]["id"])) {

                $this->_fid = $data["choices"][0]["delta"]["tool_calls"][0]["id"];

            }
            
            
            
        }

        if (isset($data["choices"][0]["finish_reason"]) && $data["choices"][0]["finish_reason"] == "tool_calls") {

            $parameterArr = json_decode($this->_parameterBuff, true) ;
            file_put_contents(__DIR__."/../log/debugStreamParsed.log",print_r($this->_parameterBuff,true));

            if (is_array($parameterArr)) {
                $parameter = current($parameterArr); // Only support for one parameter

                if (!isset($alreadysent[md5("Herika|command|{$this->_functionName}@$parameter\r\n")])) {
                    $functionCodeName=getFunctionCodeName($this->_functionName);
                    $this->_commandBuffer[]="Herika|command|$functionCodeName@$parameter\r\n";
                    file_put_contents(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR.".last_tool_call_openai.id.txt",$this->_fid);
                    //echo "Herika|command|$functionCodeName@$parameter\r\n";

                }

                $alreadysent[md5("Herika|command|{$this->_functionName}@$parameter\r\n")] = "Herika|command|{$this->_functionName}@$parameter\r\n";
                @ob_flush();
            }

        }



        return $buffer;
    }

    // Method to close the data processing operation
    public function close()
    {
        file_put_contents(__DIR__."/../log/output_from_llm.log",date(DATE_ATOM)."\n=\n".$this->_buffer."\n=\n", FILE_APPEND);

        fclose($this->primary_handler);

    }

    // Method to close the data processing operation
    public function processActions()
    {
        global $alreadysent;

        if ($this->_functionName) {
            $parameterArr = json_decode($this->_parameterBuff, true);
            if (is_array($parameterArr)) {
                $parameter = current($parameterArr); // Only support for one parameter

                if (!isset($alreadysent[md5("Herika|command|{$this->_functionName}@$parameter\r\n")])) {
                    $functionCodeName=getFunctionCodeName($this->_functionName);
                    $this->_commandBuffer[]="Herika|command|$functionCodeName@$parameter\r\n";
                    //echo "Herika|command|$functionCodeName@$parameter\r\n";

                }

                $alreadysent[md5("Herika|command|{$this->_functionName}@$parameter\r\n")] = "Herika|command|{$this->_functionName}@$parameter\r\n";
                @ob_flush();
            } else 
                return null;
        }

        return $this->_commandBuffer;
    }

    public function isDone()
    {
        return feof($this->primary_handler);
    }

}
