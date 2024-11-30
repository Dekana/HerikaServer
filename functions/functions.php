<?php

// Functions to be provided to OpenAI

$ENABLED_FUNCTIONS=[
    'Inspect',
    'LookAt',
    'InspectSurroundings',
    'MoveTo',
    'OpenInventory',
    'OpenInventory2',
    'Attack',
    'AttackHunt',
    'Follow',
    'CheckInventory',
    'SheatheWeapon',
    'Relax',
    'LeadTheWayTo',
    'TakeASeat',
    'ReadQuestJournal',
    'IncreaseWalkSpeed',
    'DecreaseWalkSpeed',
    'GetDateTime',
    'SearchDiary',
    'SetCurrentTask',
    'StopWalk',
    'TravelTo',
    'SearchMemory',
    'GiveItemToPlayer',
    'TakeGoldFromPlayer',
    'FollowPlayer'
//    'WaitHere'
];



$F_TRANSLATIONS["Inspect"]="Inspects target character's OUTFIT and GEAR. JUST REPLY something like 'Let me see' and wait";
$F_TRANSLATIONS["LookAt"]="LOOK at or Inspects NPC, Actor, or being OUTFIT and GEAR";
$F_TRANSLATIONS["InspectSurroundings"]="Looks for beings or enemies nearby";
$F_TRANSLATIONS["MoveTo"]= "Walk to a visible building or visible actor, also used to guide {$GLOBALS["PLAYER_NAME"]} to a actor or building.";
$F_TRANSLATIONS["OpenInventory"]="Initiates trading or exchange items with {$GLOBALS["PLAYER_NAME"]}.";
$F_TRANSLATIONS["OpenInventory2"]="Initiates trading, {$GLOBALS["PLAYER_NAME"]} must give items to {$GLOBALS["HERIKA_NAME"]}";
$F_TRANSLATIONS["Attack"]="Attacks actor, npc or being.";
$F_TRANSLATIONS["AttackHunt"]="Try to hunt/kill ar animal";
$F_TRANSLATIONS["Follow"]="Moves to and follow a NPC, an actor or being";
$F_TRANSLATIONS["CheckInventory"]="Search in {$GLOBALS["HERIKA_NAME"]}\'s inventory, backpack or pocket. List inventory";
$F_TRANSLATIONS["SheatheWeapon"]="Sheates current weapon";
$F_TRANSLATIONS["Relax"]="Stop questing. Relax and rest.";
$F_TRANSLATIONS["LeadTheWayTo"]="Only use if {$GLOBALS["PLAYER_NAME"]} explicitly orders it. Guide {$GLOBALS["PLAYER_NAME"]} to a Town o City. ";
$F_TRANSLATIONS["TakeASeat"]="{$GLOBALS["HERIKA_NAME"]} seats in nearby chair or furniture ";
$F_TRANSLATIONS["ReadQuestJournal"]="Only use if {$GLOBALS["PLAYER_NAME"]} explicitly ask for a quest. Get info about current quests";
$F_TRANSLATIONS["IncreaseWalkSpeed"]="Increase {$GLOBALS["HERIKA_NAME"]} speed when moving or travelling";
$F_TRANSLATIONS["DecreaseWalkSpeed"]="Decrease {$GLOBALS["HERIKA_NAME"]} speed when moving or travelling";
$F_TRANSLATIONS["GetDateTime"]="Get Current Date and Time";
$F_TRANSLATIONS["SearchDiary"]="Read {$GLOBALS["HERIKA_NAME"]}'s diary to make her remember something. Search in diary index";
$F_TRANSLATIONS["SetCurrentTask"]="Set the current plan of action or task or quest";
$F_TRANSLATIONS["ReadDiaryPage"]="Read {$GLOBALS["HERIKA_NAME"]}'s diary to access a specific topic";
$F_TRANSLATIONS["StopWalk"]="Stop all {$GLOBALS["HERIKA_NAME"]}'s actions inmediately";
$F_TRANSLATIONS["TravelTo"]="Only use if {$GLOBALS["PLAYER_NAME"]} explicitly orders it. Guide {$GLOBALS["PLAYER_NAME"]} to a Town o City. ";
$F_TRANSLATIONS["SearchMemory"]="{$GLOBALS["HERIKA_NAME"]} tries to remember information. REPLY with hashtags";
$F_TRANSLATIONS["WaitHere"]="{$GLOBALS["HERIKA_NAME"]} waits and stands at the current place";
$F_TRANSLATIONS["GiveItemToPlayer"]="{$GLOBALS["HERIKA_NAME"]} gives item (property target) to {$GLOBALS["PLAYER_NAME"]} (property listener)";
$F_TRANSLATIONS["TakeGoldFromPlayer"]="{$GLOBALS["HERIKA_NAME"]} takes amount (property target) of gold from {$GLOBALS["PLAYER_NAME"]} (property listener)";
$F_TRANSLATIONS["FollowPlayer"]="{$GLOBALS["HERIKA_NAME"]} follows  {$GLOBALS["PLAYER_NAME"]}";


$F_RETURNMESSAGES["Inspect"]="{$GLOBALS["HERIKA_NAME"]} inspects #TARGET# and see this: #RESULT#";
$F_RETURNMESSAGES["LookAt"]="LOOK at or Inspects NPC, Actor, or being OUTFIT and GEAR";
$F_RETURNMESSAGES["InspectSurroundings"]="{$GLOBALS["HERIKA_NAME"]} takes a look around and see this: #RESULT#";
$F_RETURNMESSAGES["MoveTo"]= "Walk to a visible building or visible actor, also used to guide {$GLOBALS["PLAYER_NAME"]} to a actor or building.";
$F_RETURNMESSAGES["OpenInventory"]="Initiates trading or exchange items with {$GLOBALS["PLAYER_NAME"]}. Accept gift.";
$F_RETURNMESSAGES["OpenInventory2"]="{$GLOBALS["PLAYER_NAME"]} give items to {$GLOBALS["HERIKA_NAME"]}";
$F_RETURNMESSAGES["Attack"]="{$GLOBALS["HERIKA_NAME"]} Attacks #TARGET# ";
$F_RETURNMESSAGES["AttackHunt"]="{$GLOBALS["HERIKA_NAME"]} Attacks #TARGET# ";
$F_RETURNMESSAGES["Follow"]="Moves to and follow a NPC, an actor or being";
$F_RETURNMESSAGES["CheckInventory"]="{$GLOBALS["HERIKA_NAME"]}'s INVENTORY:#RESULT#";
$F_RETURNMESSAGES["SheatheWeapon"]="Sheates current weapon";
$F_RETURNMESSAGES["Relax"]="{$GLOBALS["HERIKA_NAME"]} is relaxed. Time to enjoy life.";
$F_RETURNMESSAGES["LeadTheWayTo"]="Only use if {$GLOBALS["PLAYER_NAME"]} explicitly orders it. Guide {$GLOBALS["PLAYER_NAME"]} to a Town o City. ";
$F_RETURNMESSAGES["TakeASeat"]="{$GLOBALS["HERIKA_NAME"]} seats in nearby chair or furniture ";
$F_RETURNMESSAGES["ReadQuestJournal"]="";
$F_RETURNMESSAGES["IncreaseWalkSpeed"]="Increase {$GLOBALS["HERIKA_NAME"]} speed/pace when moving or travelling";
$F_RETURNMESSAGES["DecreaseWalkSpeed"]="Decrease {$GLOBALS["HERIKA_NAME"]} speed/pace when moving or travelling";
$F_RETURNMESSAGES["GetDateTime"]="Get Current Date and Time";
$F_RETURNMESSAGES["SearchDiary"]="Read {$GLOBALS["HERIKA_NAME"]}'s diary to make her remember something. Search in diary index";
$F_RETURNMESSAGES["SetCurrentTask"]="Set the current plan of action or task or quest";
$F_RETURNMESSAGES["ReadDiaryPage"]="Read {$GLOBALS["HERIKA_NAME"]}'s diary to access a specific topic";
$F_RETURNMESSAGES["StopWalk"]="Stop all {$GLOBALS["HERIKA_NAME"]}'s actions inmediately";
$F_RETURNMESSAGES["TravelTo"]="{$GLOBALS["HERIKA_NAME"]} begins travelling to #TARGET#";
$F_RETURNMESSAGES["SearchMemory"]="{$GLOBALS["HERIKA_NAME"]} tries to remember information. JUST REPLY something like 'Let me think' and wait";
$F_RETURNMESSAGES["WaitHere"]="{$GLOBALS["HERIKA_NAME"]} waits and stands at the place";
$F_RETURNMESSAGES["GiveItemToPlayer"]="{$GLOBALS["HERIKA_NAME"]} gave #TARGET# to {$GLOBALS["PLAYER_NAME"]}.If this a transaction, maybe TakeGoldFromPlayer is needed.";
$F_RETURNMESSAGES["TakeGoldFromPlayer"]="{$GLOBALS["PLAYER_NAME"]} gave #TARGET# coins to {$GLOBALS["HERIKA_NAME"]}. If this a transaction, maybe GiveItemToPlayer is needed.";
$F_RETURNMESSAGES["FollowPlayer"]="{$GLOBALS["HERIKA_NAME"]} follows {$GLOBALS["PLAYER_NAME"]}";


// What is this?. We can translate functions or give them a custom name. 
// This array will handle translations. Plugin must receive the codename always.

$F_NAMES["Inspect"]="Inspect";
$F_NAMES["LookAt"]="LookAt";
$F_NAMES["InspectSurroundings"]="InspectSurroundings";
$F_NAMES["MoveTo"]= "MoveTo";
$F_NAMES["OpenInventory"]="ExchangeItems";
$F_NAMES["OpenInventory2"]="TakeItemsFromPlayer";
$F_NAMES["Attack"]="Attack";
$F_NAMES["AttackHunt"]="Hunt";
$F_NAMES["Follow"]="Follow";
$F_NAMES["CheckInventory"]="ListInventory";
$F_NAMES["SheatheWeapon"]="SheatheWeapon";
$F_NAMES["Relax"]="LetsRelax";
//$F_NAMES["LeadTheWayTo"]="LeadTheWayTo";
$F_NAMES["TakeASeat"]="TakeASeat";
$F_NAMES["ReadQuestJournal"]="ReadQuestJournal";
$F_NAMES["IncreaseWalkSpeed"]="IncreaseWalkSpeed";
$F_NAMES["DecreaseWalkSpeed"]="DecreaseWalkSpeed";
$F_NAMES["GetDateTime"]="GetDateTime";
$F_NAMES["SearchDiary"]="SearchDiary";
$F_NAMES["SetCurrentTask"]="SetCurrentTask";
$F_NAMES["ReadDiaryPage"]="ReadDiaryPage";
$F_NAMES["StopWalk"]="StopWalk";
$F_NAMES["TravelTo"]="LeadTheWayTo";
$F_NAMES["SearchMemory"]="TryToRemember";
$F_NAMES["WaitHere"]="WaitHere";
$F_NAMES["GiveItemToPlayer"]="GiveItemToPlayer";
$F_NAMES["TakeGoldFromPlayer"]="TakeGoldFromPlayer";
$F_NAMES["FollowPlayer"]="FollowPlayer";


if (isset($GLOBALS["CORE_LANG"]))
	if (file_exists(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."functions.php")) 
		require_once(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."functions.php");
    
    
    
$FUNCTIONS = [
    [
        "name" => $F_NAMES["Inspect"],
        "description" => $F_TRANSLATIONS["Inspect"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Target NPC, Actor, or being",
                    "enum" => $FUNCTION_PARM_INSPECT

                ]
            ],
            "required" => ["target"],
        ],
    ],
    [
        "name" => $F_NAMES["InspectSurroundings"],
        "description" => $F_TRANSLATIONS["InspectSurroundings"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => []
        ],
    ],
    [
        "name" => $F_NAMES["LookAt"],
        "description" => $F_TRANSLATIONS["Inspect"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Target NPC, Actor, or being",
                    "enum" => $FUNCTION_PARM_INSPECT

                ]
            ],
            "required" => ["target"],
        ],
    ],
    [
        "name" => $F_NAMES["MoveTo"],
        "description" => $F_TRANSLATIONS["MoveTo"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Visible Target NPC, Actor, or being, or building.",
                    "enum" => $FUNCTION_PARM_MOVETO
                ]
            ],
            "required" => ["target"],
        ],
    ],
    [
        "name" => $F_NAMES["OpenInventory"],
        "description" => $F_TRANSLATIONS["OpenInventory"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => []
        ],
    ],
    [
        "name" => $F_NAMES["OpenInventory2"],
        "description" => $F_TRANSLATIONS["OpenInventory2"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => []
        ],
    ],
    [
        "name" => $F_NAMES["Attack"],
        "description" => $F_TRANSLATIONS["Attack"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Target NPC, Actor, or being",
                ]
            ],
            "required" => ["target"],
        ]
    ],
    [
        "name" => $F_NAMES["AttackHunt"],
        "description" => $F_TRANSLATIONS["AttackHunt"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Target animal",
                ]
            ],
            "required" => ["target"],
        ]
        ],
    [
        "name" => $F_NAMES["Follow"],
        "description" => $F_TRANSLATIONS["Follow"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Target NPC, Actor, or being",
                ]
            ],
            "required" => ["target"],
        ]
    ],
    [
        "name" => $F_NAMES["CheckInventory"],
        "description" => $F_TRANSLATIONS["CheckInventory"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "item to look for, if empty all items will be returned",
                ]
            ],
            "required" => []
        ]
    ],
    [
        "name" => $F_NAMES["SheatheWeapon"],
        "description" => $F_TRANSLATIONS["SheatheWeapon"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => []
        ]
    ],
    [
        "name" => $F_NAMES["Relax"],
        "description" => $F_TRANSLATIONS["Relax"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => []
        ]
    ],
    /*[
        "name" => $F_NAMES["LeadTheWayTo"],
        "description" => $F_TRANSLATIONS["LeadTheWayTo"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "location" => [
                    "type" => "string",
                    "description" => "Town or City to travel to, only if {$GLOBALS["PLAYER_NAME"]} explicitly orders it"
                    
                ]
            ],
            "required" => ["location"]
        ]
    ],*/
    [
        "name" => $F_NAMES["TravelTo"],
        "description" => $F_TRANSLATIONS["TravelTo"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "location" => [
                    "type" => "string",
                    "description" => "Town or City to travel to, only if {$GLOBALS["PLAYER_NAME"]} explicitly orders it"
                    
                ]
            ],
            "required" => ["location"]
        ]
    ],
    [
        "name" => $F_NAMES["TakeASeat"],
        "description" => $F_TRANSLATIONS["TakeASeat"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "Keep it blank",
                ]
            ],
            "required" => [""]
        ]
    ],
    [
        "name" => $F_NAMES["ReadQuestJournal"],
        "description" => $F_TRANSLATIONS["ReadQuestJournal"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "id_quest" => [
                    "type" => "string",
                    "description" => "Specific quest to get info for, or blank to get all",
                ]
            ],
            "required" => [""]
        ]
    ],
    [
        "name" => $F_NAMES["IncreaseWalkSpeed"],
        "description" => $F_TRANSLATIONS["IncreaseWalkSpeed"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "speed" => [
                    "type" => "string",
                    "description" => "Speed",
                    "enum" => ["run",  "jog"]
                ]

            ],
            "required" => []
        ]
    ],
     [
        "name" => $F_NAMES["DecreaseWalkSpeed"],
        "description" => $F_TRANSLATIONS["DecreaseWalkSpeed"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "speed" => [
                    "type" => "string",
                    "description" => "Speed",
                    "enum" => [ "jog", "walk"]
                ]

            ],
            "required" => []
        ]
    ],
    [
        "name" => $F_NAMES["GetDateTime"],
        "description" => $F_TRANSLATIONS["GetDateTime"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "datestring" => [
                    "type" => "string",
                    "description" => "Formatted date and time",
                ]

            ],
            "required" => []
        ]
    ],
    [
        "name" => $F_NAMES["SearchDiary"],
        "description" => $F_TRANSLATIONS["SearchDiary"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "keyword" => [
                    "type" => "string",
                    "description" => "keyword to search in full-text query syntax",
                ]
            ],
            "required" => [""]
        ]
    ],
    [
        "name" => $F_NAMES["SetCurrentTask"],
        "description" => $F_TRANSLATIONS["SetCurrentTask"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "description" => [
                    "type" => "string",
                    "description" => "Short description of current task talked by the party",
                ]
            ],
            "required" => ["description"]
        ]
    ], 
    [
        "name" => $F_NAMES["StopWalk"],
        "description" => $F_TRANSLATIONS["StopWalk"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "action",
                ]
            ],
            "required" =>[""]
        ]
    ],
     [
        "name" => $F_NAMES["SearchMemory"],
        "description" => $F_TRANSLATIONS["SearchMemory"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "",
                ]
            ],
            "required" =>[""]
        ]
    ],
    [
            "name" => $F_NAMES["WaitHere"],
            "description" => $F_TRANSLATIONS["WaitHere"],
            "parameters" => [
                "type" => "object",
                "properties" => [
                    "target" => [
                        "type" => "string",
                        "description" => "",
                    ]
                ],
                "required" =>[""]
            ]
    ],
    [
            "name" => $F_NAMES["GiveItemToPlayer"],
            "description" => $F_TRANSLATIONS["GiveItemToPlayer"],
            "parameters" => [
                "type" => "object",
                "properties" => [
                    "target" => [
                        "type" => "string",
                        "description" => "",
                    ]
                ],
                "required" =>["target"]
            ]
    ],
    [
        "name" => $F_NAMES["TakeGoldFromPlayer"],
        "description" => $F_TRANSLATIONS["TakeGoldFromPlayer"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "target" => [
                    "type" => "string",
                    "description" => "",
                ]
            ],
            "required" =>["target"]
        ]
    ],
    [
            "name" => $F_NAMES["FollowPlayer"],
            "description" => $F_TRANSLATIONS["FollowPlayer"],
            "parameters" => [
                "type" => "object",
                "properties" => [
                    "target" => [
                        "type" => "string",
                        "description" => "",
                    ]
                ],
                "required" =>[""]
            ]
    ]
    
];



// This function only is offered when SearchDiary
$FUNCTIONS_GHOSTED =  [
        "name" => $F_NAMES["ReadDiaryPage"],
        "description" => $F_TRANSLATIONS["ReadDiaryPage"],
        "parameters" => [
            "type" => "object",
            "properties" => [
                "page" => [
                    "type" => "string",
                    "description" => "topic to search in full-text query syntax",
                ]
            ],
            "required" => ["topic"]
        ]
    ]
    ;

function getFunctionCodeName($key) {
    
    $functionCode=array_search($key, $GLOBALS["F_NAMES"]);
    return $functionCode;
    
}

function getFunctionTrlName($key) {
    return $GLOBALS["F_NAMES"][$key];
    
}

function findFunctionByName($name) {
    foreach ($GLOBALS["FUNCTIONS"] as $function) {
        if ($function['name'] === $name) {
            return $function;
        }
    }
    return null; // Return null if function not found
}


function requireFunctionFilesRecursively($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $dir . '/' . $file;

        if (is_dir($path)) {
            requireFunctionFilesRecursively($path);
        } elseif (is_file($path) && $file === 'functions.php') {
            require_once $path;
        } 
    }
}

if (isset($GLOBALS["IS_NPC"])&&$GLOBALS["IS_NPC"]) { 
    $GLOBALS["ENABLED_FUNCTIONS"]=[
        'Inspect',
        //'LookAt',
        'InspectSurroundings',
        //'MoveTo',
        'OpenInventory',
        'Attack',
        'AttackHunt',
        'TravelTo',
        //'Follow',
        'CheckInventory',
        //'SheatheWeapon',
        'Relax',
        //'LeadTheWayTo',
        'TakeASeat',
        'IncreaseWalkSpeed',
        'DecreaseWalkSpeed',
        //'GetDateTime',
        //'SearchDiary',
        //'SetCurrentTask',
        //'SearchMemory',
        //'StopWalk'
        'WaitHere',
        //'GiveItemToPlayer',
        //'TakeGoldFromPlayer',
        //'FollowPlayer'
    ];
} else {
    $GLOBALS["ENABLED_FUNCTIONS"]=[
        'Inspect',
        //'LookAt',
        'InspectSurroundings',
        //'MoveTo',
        'OpenInventory',
        'Attack',
        'AttackHunt',
        'TravelTo',
        //'Follow',
        'CheckInventory',
        //'SheatheWeapon',
        'Relax',
        //'LeadTheWayTo',
        'TakeASeat',
        'ReadQuestJournal',
        'IncreaseWalkSpeed',
        'DecreaseWalkSpeed',
        'WaitHere',
        'SetCurrentTask',
        //'GiveItemToPlayer',
        //'TakeGoldFromPlayer'
        //'GetDateTime',
        //'SearchDiary',
        //'SearchMemory',
        //'StopWalk'
    ];

}


$folderPath = __DIR__.DIRECTORY_SEPARATOR."../ext/";
requireFunctionFilesRecursively($folderPath);


if (file_exists(__DIR__.DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."prompts.php")) {
    require(__DIR__.DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$GLOBALS["CORE_LANG"].DIRECTORY_SEPARATOR."prompts.php");
}

if (file_exists(__DIR__.DIRECTORY_SEPARATOR."../prompts/prompts_custom.php")) {
    require(__DIR__.DIRECTORY_SEPARATOR."../prompts/prompts_custom.php");
}



// Delete non wanted functions    

foreach ($FUNCTIONS as $n=>$v)
    if (!in_array(getFunctionCodeName($v["name"]),$ENABLED_FUNCTIONS)) {
            unset($FUNCTIONS[$n]);
    }

    $FUNCTIONS=array_values($FUNCTIONS); //Get rid of array keys


?>
