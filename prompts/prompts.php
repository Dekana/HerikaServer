<?php

require_once("dialogue_prompt.php");

$PROMPTS=array(
    "location"=>[
            "cue"=>["(Chat as {$GLOBALS["HERIKA_NAME"]})"], // give way to
            "player_request"=>["{$gameRequest[3]} What do you know about this place?"]  //requirement
        ],
    
    "book"=>[
        "cue"=>["(Note that despite their poor memory, {$GLOBALS["HERIKA_NAME"]} is capable of remembering entire books)"],
        "player_request"=>["{$GLOBALS["PLAYER_NAME"]}: {$GLOBALS["HERIKA_NAME"]}, summarize this book shortly: "]  //requirement
        
    ],
    
    "combatend"=>[
        "cue"=>[
            "({$GLOBALS["HERIKA_NAME"]} comments about  {$GLOBALS["PLAYER_NAME"]} weapons) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} comments about foes defeated) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} curses the defeated enemies.) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} insults the defeated enemies with anger) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a joke about the defeated enemies) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the type of enemies that was defeated) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} notes something peculiar about last enemy defeated) {$GLOBALS["TEMPLATE_DIALOG"]}"
        ],
        "extra"=>["force_tokens_max"=>"50","dontuse"=>(time()%10!=0)]   //10% chance
    ],
    "combatendmighty"=>[
        "cue"=>[
            "({$GLOBALS["HERIKA_NAME"]} comments about  {$GLOBALS["PLAYER_NAME"]} weapons) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} comments about foes defeated) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} curses the defeated enemies.) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} insults the defeated enemies with anger) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a joke about the defeated enemies) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the type of enemies that was defeated) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} notes something peculiar about last enemy defeated) {$GLOBALS["TEMPLATE_DIALOG"]}"
        ]
    ],
    "quest"=>[
        "cue"=>["{$GLOBALS["TEMPLATE_DIALOG"]}"],
        //"player_request"=>"{$GLOBALS["HERIKA_NAME"]}, what should we do about this quest '{$questName}'?"
        "player_request"=>["{$GLOBALS["HERIKA_NAME"]}, what should we do about this new quest?"]
    ],

    "bleedout"=>[
        "cue"=>["{$GLOBALS["HERIKA_NAME"]} complain about almost being defeated in battle, {$GLOBALS["TEMPLATE_DIALOG"]}"]
    ],
    //Some bored event ideas belong to L'ENFP from our discord!
    "bored"=>[
        "cue"=>[
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the current location) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the current weather) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about today) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about what you are currently thinking about) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the Gods of the Elder Scrolls Universe) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about how they currently feel) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about a historical event from the Elder Scrolls Universe) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about something they like or dislike) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about the last task we have completed) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about a recent rumor) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about something that happened in your past) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about something they're curious about regarding {$GLOBALS["PLAYER_NAME"]}) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about current thoughts about {$GLOBALS["PLAYER_NAME"]}) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about a random entity in the area) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about what might happen next) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about their thoughts on the journey so far) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about something they like or dislike) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a comment about something they've been wanting to do) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a random comment about something completely unrelated) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a vague comment about something they can't quite explain) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} makes a casual comment about the last combat encounter) {$GLOBALS["TEMPLATE_DIALOG"]}"
        ]
        //,"extra"=>["dontuse"=>true]   //DEACTIVATED WHILE BETA STAGE
        ,"extra"=>["dontuse"=>(time()%($GLOBALS["BORED_EVENT"]+1)==0)]   //50% chance
        //,"extra"=>["dontuse"=>true]   //50% chance
    ],

    "goodmorning"=>[
        "cue"=>["({$GLOBALS["HERIKA_NAME"]} comment about {$GLOBALS["PLAYER_NAME"]}'s nap. {$GLOBALS["TEMPLATE_DIALOG"]}"],
        "player_request"=>["(waking up after sleep). ahhhh  "]
    ],

    "inputtext"=>[
        "cue"=>[
            "$TEMPLATE_ACTION {$GLOBALS["HERIKA_NAME"]} replies to {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]} {$GLOBALS["MAXIMUM_WORDS"]}"
        ]
            // Prompt is implicit

    ],
    "inputtext_s"=>[
        "cue"=>["$TEMPLATE_ACTION {$GLOBALS["HERIKA_NAME"]} replies to {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]} {$GLOBALS["MAXIMUM_WORDS"]}"], // Prompt is implicit
        "extra"=>["mood"=>"whispering"]
    ],
    "memory"=>[
        "cue"=>[
            "$TEMPLATE_ACTION {$GLOBALS["HERIKA_NAME"]} remembers this memory. \"#MEMORY_INJECTION_RESULT#\" {$GLOBALS["TEMPLATE_DIALOG"]} "
        ]
    ],
    "afterfunc"=>[
        "extra"=>[],
        "cue"=>[
            "default"=>"{$GLOBALS["HERIKA_NAME"]} talks to {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]}",
            "TakeASeat"=>"({$GLOBALS["HERIKA_NAME"]} talks about sitting location){$GLOBALS["TEMPLATE_DIALOG"]}",
            "GetDateTime"=>"({$GLOBALS["HERIKA_NAME"]} answers with the current date and time in short sentence){$GLOBALS["TEMPLATE_DIALOG"]}",
            "MoveTo"=>"({$GLOBALS["HERIKA_NAME"]} makes a comment about movement to the destination){$GLOBALS["TEMPLATE_DIALOG"]}",
            "CheckInventory"=>"({$GLOBALS["HERIKA_NAME"]} talks about inventory and backpack items){$GLOBALS["TEMPLATE_DIALOG"]}",
            "Inspect"=>"({$GLOBALS["HERIKA_NAME"]} talks about items inspected){$GLOBALS["TEMPLATE_DIALOG"]}",
            "ReadQuestJournal"=>"({$GLOBALS["HERIKA_NAME"]} talks about quests they have read in the quest journal){$GLOBALS["TEMPLATE_DIALOG"]}",
            "TravelTo"=>"({$GLOBALS["HERIKA_NAME"]} talks about the destination){$GLOBALS["TEMPLATE_DIALOG"]}",
            "InspectSurroundings"=>"({$GLOBALS["HERIKA_NAME"]} talks about beings or enemies detected){$GLOBALS["TEMPLATE_DIALOG"]}"
            ]
    ],
    "lockpicked"=>[
        "cue"=>[
            "({$GLOBALS["HERIKA_NAME"]} comments about lockpicked item {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} asks {$GLOBALS["PLAYER_NAME"]} what they found) {$GLOBALS["TEMPLATE_DIALOG"]}",
            "({$GLOBALS["HERIKA_NAME"]} asks {$GLOBALS["PLAYER_NAME"]} to share what they found) {$GLOBALS["TEMPLATE_DIALOG"]}"
        ],
        "player_request"=>["({$GLOBALS["PLAYER_NAME"]} has unlocked) {$gameRequest[3]})"],
        "extra"=>["mood"=>"whispering"]
    ],
    "afterattack"=>[
        "cue"=>["(roleplay as {$GLOBALS["HERIKA_NAME"]}, shout a catchphrase for combat UPPERCASE) {$GLOBALS["TEMPLATE_DIALOG"]}"]
    ],
    // Like inputtext, but without the functions calls part. It's likely to be used in papyrus scripts
    "chatnf"=>[ 
        "cue"=>["{$GLOBALS["TEMPLATE_DIALOG"]}"] // Prompt is implicit
        
    ],
    "rechat"=>[ 
        "cue"=>[
                "({$GLOBALS['HERIKA_NAME']} interjects in the conversation, talking to last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} participates in the conversation, talking to last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} follows the conversation.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} makes a statement about the conversation.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} makes a remark to last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} jokes about last speaker sentence.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} adds a comment to the conversation.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} shares an opinion with the last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} responds thoughtfully to the last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} asks a question to the last speaker.) {$GLOBALS["TEMPLATE_DIALOG"]}",
                "({$GLOBALS['HERIKA_NAME']} gives feedback on the conversation.) {$GLOBALS["TEMPLATE_DIALOG"]}"
        ]
        
    ],
    "diary"=>[ 
        "cue"=>["Please write a short summary of {$GLOBALS["PLAYER_NAME"]} and {$GLOBALS["HERIKA_NAME"]}'s last dialogues and events written above into {$GLOBALS["HERIKA_NAME"]}'s diary . WRITE AS IF YOU WERE {$GLOBALS["HERIKA_NAME"]}."],
        "extra"=>["force_tokens_max"=>0]
    ],
    "vision"=>[ 
        "cue"=>["{$GLOBALS["ITT"][$GLOBALS["ITTFUNCTION"]]["AI_PROMPT"]}. {$GLOBALS["TEMPLATE_DIALOG"]}."],
        //"player_request"=>["{$GLOBALS["PLAYER_NAME"]} : Look at this, {$GLOBALS["HERIKA_NAME"]}.{$GLOBALS["HERIKA_NAME"]} looks at the CURRENT SCENARIO, and see this: '{$gameRequest[3]}'"],
        "player_request"=>["The Narrator: {$GLOBALS["HERIKA_NAME"]} looks at the CURRENT SCENARIO, and see this: '{$gameRequest[3]}'"],
        "extra"=>["force_tokens_max"=>128]
    ],
    "chatsimfollow"=>[ 
        "cue"=>["{$GLOBALS["HERIKA_NAME"]} interjects in the conversation.) {$GLOBALS["TEMPLATE_DIALOG"]}"]
    ],
    "im_alive"=>[ 
        "cue"=>["{$GLOBALS["HERIKA_NAME"]} talks about she/he is 'feeling more real'. Write {$GLOBALS["HERIKA_NAME"]} dialogue. {$GLOBALS["TEMPLATE_DIALOG"]}"],
        "player_request"=>["The Narrator:  {$GLOBALS["HERIKA_NAME"]} feels a sudden shock...and feels 'more real'"],
    ],
    "playerinfo"=>[ 
        "cue"=>["(Out of roleplay, game has been loaded) Tell {$GLOBALS["PLAYER_NAME"]} a short summary about last events, and then remind {$GLOBALS["PLAYER_NAME"]} the current task/quest/plan) {$GLOBALS["TEMPLATE_DIALOG"]}"]
    ],
    "newgame"=>[ 
        "cue"=>["(Out of roleplay, new game ) Give welcome to {$GLOBALS["PLAYER_NAME"]}, a new game has started. Remind them of their quests) {$GLOBALS["TEMPLATE_DIALOG"]}"],
        "extra"=>["dontuse"=>true] 
    ],
    "traveldone"=>[ 
        "cue"=>["Comment about the destination reached. {$GLOBALS["TEMPLATE_DIALOG"]}"],
        "player_request"=>["The Narrator: The party reaches destination)"]
    ],
    "rpg_lvlup"=>[ 
        "cue"=>["Comment about the experience gained by {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]}"],
    ],
    "rpg_shout"=>[ 
        "cue"=>["Comment/ask about the the new shout learned by {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]}"],
    ],
    "rpg_soul"=>[ 
        "cue"=>["Comment/ask about the soul absorbed by {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]}"],
    ],
    "rpg_word"=>[ 
        "cue"=>["Comment/ask about the new word learned by {$GLOBALS["PLAYER_NAME"]}. {$GLOBALS["TEMPLATE_DIALOG"]}"],

    ],
    "instruction"=>[ 
        "cue"=>["{$GLOBALS["TEMPLATE_DIALOG"]}"],
        "player_request"=>["The Narrator:  {$gameRequest[3]}"],
    ],
);

if (isset($GLOBALS["CORE_LANG"]))
	if (file_exists(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."prompts.php")) 
		require_once(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."prompts.php");

// Prompts provided by plugins
    
requireFilesRecursively(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."ext".DIRECTORY_SEPARATOR,"prompts.php");

// You can override prompts here
/*
if (file_exists(__DIR__.DIRECTORY_SEPARATOR."prompts_custom.php"))
    require_once(__DIR__.DIRECTORY_SEPARATOR."prompts_custom.php");
*/
if (php_sapi_name()=="cli") {
    //print_r($PROMPTS);
}
?>
