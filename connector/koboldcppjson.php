<?php

/* kolboldcpp connector */

class koboldcppjson
{
    public $primary_handler;
    public $name;

    public $_functionMode;
    public $_extractedbuffer;
    private $_ignoreRest;
    private $_functionRawName;
    private $_functionName;
    private $_parameterBuff;
    private $_commandBuffer;
    private $_jsonMode;
    private $_jsonBuffer;

    public function __construct()
    {
        $this->name="koboldcppjson";
        $this->_ignoreRest=false;
        $this->_jsonMode=true; 
        $this->_extractedbuffer="";
        require_once(__DIR__."/__jpd.php");
         
    }


    public function open(&$contextData, $customParms)
    {
        $path='/api/extra/generate/stream/';
        $url=$GLOBALS["CONNECTOR"][$this->name]["url"].$path;
        $context="";

        
        $GLOBALS["PROMPT_HEAD"]=strtr($GLOBALS["PROMPT_HEAD"],["#PLAYER_NAME#"=>$GLOBALS["PLAYER_NAME"]]);
        $GLOBALS["HERIKA_PERS"]=strtr($GLOBALS["HERIKA_PERS"],["#PLAYER_NAME#"=>$GLOBALS["PLAYER_NAME"]]);

        foreach ($contextData as $n=>$s_msg) {	// Have to mangle context format

            if (!isset($s_msg["content"])) {
                error_log("Entry $n without content");
                continue;
            }
            
            if (empty(trim($s_msg["content"]))) {
                unset($contextData[$n]);
                continue;
            } else {
                // This should be customizable per model
                /*
                if ($s_msg["role"]=="user")
                    $normalizedContext[]="### Instruction: ".$s_msg["content"];
                else if ($s_msg["role"]=="assistant")
                    $normalizedContext[]="### Response: ".$s_msg["content"];
                else if ($s_msg["role"]=="system")
                    $normalizedContext[]=$s_msg["content"];
                */
                $normalizedContext[]=$s_msg["content"];
            }
        }

        $stop_sequence=["{$GLOBALS["PLAYER_NAME"]}:","\n{$GLOBALS["PLAYER_NAME"]} ","Author's notes","###"];

        require_once(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."json_response.php");

        /* This is handled in the template files
        if (isset($GLOBALS["FUNCTIONS_ARE_ENABLED"]) && $GLOBALS["FUNCTIONS_ARE_ENABLED"]) {
            $contextData[0]["content"].=$GLOBALS["COMMAND_PROMPT"];
        }
        */

        if (isset($GLOBALS["PATCH_PROMPT_ENFORCE_ACTIONS"]) && $GLOBALS["PATCH_PROMPT_ENFORCE_ACTIONS"]) {
            $prefix="{$GLOBALS["COMMAND_PROMPT_ENFORCE_ACTIONS"]}";
        }
        $prefix="{$GLOBALS["COMMAND_PROMPT_ENFORCE_ACTIONS"]}";

        if (strpos($GLOBALS["HERIKA_PERS"],"#SpeechStyle")!==false) {
            $speechReinforcement="Use #SpeechStyle. ";
        } else
            $speechReinforcement="";

        $contextData[]=[
            'role' => 'user',
            'content' => "{$prefix}. $speechReinforcement Use this JSON object to give your answer: ".json_encode($GLOBALS["responseTemplate"])
        ];
        
        if ($GLOBALS["CONNECTOR"][$this->name]["template"]=="alpaca") {
           
            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="vicuna-1") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");
           

        }  elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="vicuna-1.1") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="chatml") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="chatml-c") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="synthia") {


            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");



        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="extended-alpaca") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="superHOT") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="zephyr") {

            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");


        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="openchat") {

           
            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");

        } elseif ($GLOBALS["CONNECTOR"][$this->name]["template"]=="dreamgen") {

           
            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");

        } elseif (file_exists(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php")) {

            error_log("Using template ".__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");
            include(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."{$GLOBALS["CONNECTOR"][$this->name]["template"]}.php");

        }

       
        
        $TEMPERATURE=((isset($GLOBALS["CONNECTOR"][$this->name]["temperature"]) ? $GLOBALS["CONNECTOR"][$this->name]["temperature"] : 0.9)+0);
        $REP_PEN=((isset($GLOBALS["CONNECTOR"][$this->name]["rep_pen"]) ? $GLOBALS["CONNECTOR"][$this->name]["rep_pen"] : 1.12)+0);
        $TOP_P=((isset($GLOBALS["CONNECTOR"][$this->name]["top_p"]) ? $GLOBALS["CONNECTOR"][$this->name]["top_p"] : 0.9)+0);

        $MAX_TOKENS=((isset($GLOBALS["CONNECTOR"][$this->name]["max_tokens"]) ? $GLOBALS["CONNECTOR"][$this->name]["max_tokens"] : 48)+0);


        if ($GLOBALS["CONNECTOR"][$this->name]["newline_as_stopseq"]) {
            $stop_sequence[]="\n";
        }

        if (isset($GLOBALS["more_stopseq"])) {
            foreach ($GLOBALS["more_stopseq"] as $stopseq)
                $stop_sequence[]=$stopseq;
        }

        
        ///
        $stop_sequence[]=$GLOBALS["CONNECTOR"][$this->name]["eos_token"];
        ///
        $postData = array(

            "prompt"=>$context,
            "temperature"=> $TEMPERATURE,
            "top_p"=>$TOP_P,
            //"max_context_length"=>2048,
            "max_length"=>$MAX_TOKENS,
            "min_p"=>$GLOBALS["CONNECTOR"][$this->name]["min_p"]+0,
            "top_k"=>$GLOBALS["CONNECTOR"][$this->name]["top_k"]+0,
            "rep_pen"=>$REP_PEN,
            "stop_sequence"=>$stop_sequence,
            "use_default_badwordsids"=>$GLOBALS["CONNECTOR"][$this->name]["use_default_badwordsids"],
            "trim_stop"=>true

        );

        if ((isset($GLOBALS["CONNECTOR"][$this->name]["eos_token"]))&&!empty($GLOBALS["CONNECTOR"][$this->name]["eos_token"])) {
                $eos_token_allow_grammar='| "'.$GLOBALS["CONNECTOR"][$this->name]["eos_token"].'"';
        } else
            $eos_token_allow_grammar='';

        $moodsText='"';
        //  ("["whispering"|"dazed"|"default"]*")"
        if (@is_array($GLOBALS["TTS"]["AZURE"]["validMoods"]) &&  sizeof($GLOBALS["TTS"]["AZURE"]["validMoods"])>0)
            if ($GLOBALS["TTSFUNCTION"]=="azure")
                $moodsText='("["' . implode('","', $GLOBALS["TTS"]["AZURE"]["validMoods"]) . '"]*")"';


        $postData["grammar"]=$GLOBALS["grammar"];

        if (!$GLOBALS["CONNECTOR"][$this->name]["grammar"])
            unset($postData["grammar"]);


        if (isset($customParms["MAX_TOKENS"])) {
            if ($customParms["MAX_TOKENS"]==null) {
                unset($postData["max_length"]);
            } elseif ($customParms["MAX_TOKENS"]) {
                $postData["max_length"]=$customParms["MAX_TOKENS"]+0;
            }
        }

        if (isset($GLOBALS["FORCE_MAX_TOKENS"])) {
            if ($GLOBALS["FORCE_MAX_TOKENS"]==null) {
                unset($postData["max_length"]);
            } else {
                $postData["max_length"]=$GLOBALS["FORCE_MAX_TOKENS"]+0;
            }

        }

        
        $GLOBALS["DEBUG_DATA"]["koboldcpp_prompt"]=$postData;

        $headers = array(
            'Content-Type: application/json'
        );

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $headers),
                'content' => json_encode($postData)
            )
        );
        error_reporting(E_ALL);
        $context = stream_context_create($options);


        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);
        $scheme = parse_url($url, PHP_URL_SCHEME);


        // Data to send in JSON format
        $dataJson = json_encode($postData);

        
        //print_r($postData);
        $request = "POST $path HTTP/1.1\r\n";
        $request .= "Host: $host\r\n";
        $request .= "Content-Type: application/json\r\n";
        $request .= "Content-Length: " . strlen($dataJson) . "\r\n";
        $request .= "Connection: close\r\n\r\n";
        $request .= $dataJson;

        // Open a TCP connection
        file_put_contents(__DIR__."/../log/context_sent_to_llm.log",date(DATE_ATOM)."\n=\n".var_export($postData,true)."\n=\n", FILE_APPEND);

                
        //$this->primary_handler = fsockopen('tcp://' . $host, $port, $errno, $errstr, 30);
        if ($scheme=="https")
            $this->primary_handler = fsockopen('ssl://' . $host, 443, $errno, $errstr, 30);
        else
            $this->primary_handler = fsockopen('tcp://' . $host, $port, $errno, $errstr, 30);

        // Send the HTTP request
        if ($this->primary_handler !== false) {
            fwrite($this->primary_handler, $request);
            fflush($this->primary_handler);
        } else if (($this->primary_handler == null) || (!$this->primary_handler)){
             error_log("Unable to connect to koboldcpp backend!");
            return false;
        }


        // Initialize variables for response
        $responseHeaders = '';
        $responseBody = '';
        
        $this->_jsonBuffer="";
        
        return true;

    }


    public function process()
    {
        $line = fgets($this->primary_handler);
        $buffer="";
        $totalBuffer="";
        $mangledBuffer="";
        file_put_contents(__DIR__."/../log/debugStream.log", $line, FILE_APPEND);
       
        
        if (!empty($GLOBALS["PATCH"]["PREAPPEND"])) {
            $this->_jsonBuffer=$GLOBALS["PATCH"]["PREAPPEND"];
            $GLOBALS["PATCH"]["PREAPPEND"]="";
        }
        
        if (strpos($line, 'data: {') !== 0) {
            return "";
        }
        

        $data=json_decode(substr($line, 6), true);


        if (!$data)
            return "";
        
        
 
        if (isset($data["token"])) {
            $this->_jsonBuffer.=$data["token"];
            unset($GLOBALS["_JSON_BUFFER"]);
            $partialResult=__jpd_decode_lazy($this->_jsonBuffer);
            
            if (isset($partialResult["message"]))
                $partialResult[0]=$partialResult;   // __jpd_decode_lazy changes struct when JSON is completed
            
            
            if (is_array($partialResult)&&isset($partialResult[0]["message"])) {
                if (isset($partialResult[0]["action"])) {
                    if (($partialResult[0]["action"]=="Inspect")) {
                        return "";
                    }
                }
                // workaround for some LLMs that return an array of strings for the dialogue in the JSON response.
                if (is_array($partialResult[0]["message"])) {
                    $mangledBuffer = str_replace($this->_extractedbuffer, "", implode(" ",$partialResult[0]["message"]));
                } else {
                    $mangledBuffer = str_replace($this->_extractedbuffer, "", $partialResult[0]["message"]);
                }
                // echo "*{$this->_jsonBuffer}".PHP_EOL;
                $this->_extractedbuffer=$partialResult[0]["message"];
                if (isset($partialResult[0]["listener"])) {
                    if (isset($partialResult[0]["action"])&&($partialResult[0]["action"]=="Talk")&& lazyEmpty($partialResult[0]["listener"]) && !lazyEmpty($partialResult[0]["target"]))
                        $GLOBALS["SCRIPTLINE_LISTENER"]=$partialResult[0]["target"];
                    else
                        $GLOBALS["SCRIPTLINE_LISTENER"]=$partialResult[0]["listener"];

                     
                }
                
                if (isset($partialResult[0]["mood"])) {
                    $GLOBALS["SCRIPTLINE_ANIMATION"]=GetAnimationHex($partialResult[0]["mood"]);
                    $GLOBALS["SCRIPTLINE_EXPRESSION"]=GetExpression($partialResult[0]["mood"]);
                }
                
            }
            
            $totalBuffer.=$data["token"];
        }

        
        return $mangledBuffer;
    }


    public function close()
    {
        // /api/extra/abort ?
        while (!feof($this->primary_handler))   // buffer flush?
            fgets($this->primary_handler);

        fclose($this->primary_handler);
        $GLOBALS["DEBUG_DATA"]["RAW"]=$this->_jsonBuffer;

        //file_put_contents(__DIR__."/../log/output_from_llm.log",$this->_jsonBuffer, FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__."/../log/output_from_llm.log",date(DATE_ATOM)."\n=\n".$this->_jsonBuffer."\n=\n", FILE_APPEND);


    }

    public function isDone()
    {
        if ($this->_ignoreRest)
            return true;

        return feof($this->primary_handler);
    }

    public function processActions()
    {
        global $alreadysent;

        unset($GLOBALS["_JSON_BUFFER"]);    // __jpd_decode_lazy has a cache
        
        $jsonData=__jpd_decode_lazy($this->_jsonBuffer);
        
        //error_log($this->_jsonBuffer);
        //print_r($jsonData);
        
        if (is_array($jsonData)) {  // ??
            if (isset($jsonData[0])&& is_array($jsonData[0]))
                $jsonData=$jsonData[0];
        }
        
        $this->_commandBuffer=[];

        $GLOBALS["DEBUG_DATA"]["RAW"]=$this->_jsonBuffer;
        
        if (is_array($jsonData)&&isset($jsonData["action"])) { // !!!
            $parsedResponse=$jsonData;
            
            if (!empty($parsedResponse["action"])) {
                if (!isset($alreadysent[md5("{$GLOBALS["HERIKA_NAME"]}|command|{$parsedResponse["action"]}@{$parsedResponse["target"]}\r\n")])) {
                    
                    $functionDef=findFunctionByName(trim($parsedResponse["action"]));
                    if ($functionDef) {
                        $functionCodeName=getFunctionCodeName($parsedResponse["action"]);
                        if (@strlen($functionDef["parameters"]["required"][0])>0) {
                            if (!empty($parsedResponse["target"])) {
                                $this->_commandBuffer[]="{$GLOBALS["HERIKA_NAME"]}|command|$functionCodeName@{$parsedResponse["target"]}\r\n";
                            }
                            else {
                                error_log("Missing required parameter");
                            }
                                
                        } else {
                            $this->_commandBuffer[]="{$GLOBALS["HERIKA_NAME"]}|command|$functionCodeName@{$parsedResponse["target"]}\r\n";
                        }
                    } elseif ($parsedResponse["action"] != "Talk") {
                        error_log("Function not found for {$parsedResponse["action"]}");
                    }
                    
                    //$functionCodeName=getFunctionCodeName($parsedResponse["action"]);
                    //$this->_commandBuffer[]="{$GLOBALS["HERIKA_NAME"]}|command|{$parsedResponse["action"]}@{$parsedResponse["target"]}\r\n";
                    //echo "Herika|command|$functionCodeName@$parameter\r\n";
                    $alreadysent[md5("{$GLOBALS["HERIKA_NAME"]}|command|{$parsedResponse["action"]}@{$parsedResponse["target"]}\r\n")]=end($this->_commandBuffer);
                
                } else {
                      error_log("Function not found for {$parsedResponse["action"]} already sent");
                }
                    
            }
        }
        
        //print_r($this->_jsonBuffer);
        return is_array($this->_commandBuffer)?$this->_commandBuffer:[];
        
    }


}
