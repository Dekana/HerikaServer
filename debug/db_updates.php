<?php 


// Add people info to event log

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'eventlog' AND column_name = 'people'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('ALTER TABLE "eventlog" ADD COLUMN "people" text');
    echo '<script>alert("A patch (0.1.2) has been applied to Database")</script>';
}

// Add location info to event log

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'eventlog' AND column_name = 'location'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('ALTER TABLE "eventlog" ADD COLUMN "location" text');
    echo '<script>alert("A patch (0.1.3) has been applied to Database")</script>';
}

// Add party info to event log
$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'eventlog' AND column_name = 'party'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('ALTER TABLE "eventlog" ADD COLUMN "party" text');
    echo '<script>alert("A patch (0.1.4p1) has been applied to Database")</script>';
}

// Add tags to memory summary
$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'memory_summary' AND column_name = 'tags'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('ALTER TABLE "memory_summary" ADD COLUMN "tags" text');
    echo '<script>alert("A patch (0.1.4p2) has been applied to Database")</script>';
}

// Ensure native_vec is created
$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'memory_summary' AND column_name = 'native_vec'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('ALTER TABLE "memory_summary" ADD COLUMN "native_vec" TSVECTOR');
    $db->execQuery('CREATE INDEX memory_summary_tsv_idx ON articles USING GIN(native_vec);');
    echo '<script>alert("A patch (0.1.4p3) has been applied to Database")</script>';
}

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'audit_memory' AND column_name = 'keywords'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('
    CREATE TABLE public.audit_memory (
    input text,
    keywords text,
    rank_any numeric(20,10),
    rank_all numeric(20,10),
    memory text,
    "time" text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
)');
    echo '<script>alert("A patch (0.1.5p1) has been applied to Database")</script>';
}

// Memory ts
$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'memory' AND column_name = 'ts'
";


$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
        $db->execQuery('ALTER TABLE "memory" ADD COLUMN "ts" bigint');
        $db->execQuery("CREATE OR REPLACE VIEW public.memory_v AS
 SELECT message,
    uid,
    gamets,
    speaker,
    listener,
    ts
   FROM ( SELECT memory.message,
            CAST(memory.uid AS integer),
            memory.gamets,
            '-'::text AS speaker,
            '-'::text AS listener,
           ts
           FROM public.memory
          WHERE ((memory.message !~~ 'Dear Diary%'::text) AND (memory.message <> ''::text))
        UNION
         SELECT ((((('(Context Location:'::text || speech.location) || ') '::text) || speech.speaker) || ': '::text) || speech.speech),
            CAST(speech.rowid AS integer),
            speech.gamets,
            speech.speaker,
            speech.listener,
            speech.ts
           FROM public.speech
          WHERE (speech.speech <> ''::text)
        UNION
         SELECT eventlog.data,
            CAST(eventlog.rowid AS integer),
            eventlog.gamets,
            '-'::text AS text,
            '-'::text AS listener,
            eventlog.ts
           FROM public.eventlog
          WHERE ((eventlog.type)::text = ANY (ARRAY[('death'::character varying)::text, ('location'::character varying)::text]))) subquery
  ORDER BY gamets, ts;
");

        echo '<script>alert("A patch (0.1.6p1) has been applied to Database")</script>';
    
}

// Npc profile backup

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'npc_profile_backup'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
        $db->execQuery("CREATE TABLE public.npc_profile_backup (
    \"name\" text,
    \"data\" text,
    \"created_at\" timestamp without time zone DEFAULT CURRENT_TIMESTAMP
    )
    ");
    echo '<script>alert("A patch (0.1.7p1) has been applied to Database")</script>';

}



$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'npc_profile_backup'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
        $db->execQuery("CREATE TABLE public.npc_profile_backup (
    \"name\" text,
    \"data\" text,
    \"created_at\" timestamp without time zone DEFAULT CURRENT_TIMESTAMP
    )
    ");
    echo '<script>alert("A patch (0.1.7p1) has been applied to Database")</script>';

}

$query = "select npc_name from npc_templates where npc_name='neiva_deep_water'";
$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["npc_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/npc_neiva_update.sql"));
    echo '<script>alert("A patch (neiva follower) has been applied to Database")</script>';
}


$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'audit_request' AND column_name = 'request'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery('
    CREATE TABLE public.audit_request (
        request text,
        result text,
        created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
        rowid bigint NOT NULL
    );
    CREATE SEQUENCE public.audit_request_rowid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
    ALTER TABLE ONLY public.audit_request ALTER COLUMN rowid SET DEFAULT nextval(\'public.audit_request_rowid_seq\'::regclass);
    ALTER TABLE ONLY public.audit_request ADD CONSTRAINT audit_request_primary PRIMARY KEY (rowid);

');
    echo '<script>alert("A patch (0.9.7) has been applied to Database")</script>';
}


$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'oghma' AND column_name = 'topic'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/oghma_infinium.sql"));
    echo '<script>alert("A patch (oghma_infinium) has been applied to Database")</script>';
}

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'oghma' AND column_name = 'native_vector'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/oghma_infinium2.sql"));
    echo '<script>alert("A patch (oghma_infinium) has been applied to Database")</script>';
}

$db->execQuery("update public.oghma SET native_vector = setweight(to_tsvector(coalesce(topic, '')),'A')||setweight(to_tsvector(coalesce(topic_desc, '')),'B')");


$query = "SELECT 1 as bad_syntax_exists  FROM public.npc_templates WHERE  npc_name LIKE '%' || CHR(39) || '%'";

$existsColumn=$db->fetchAll($query);
if ($existsColumn[0]["bad_syntax_exists"]) {
    $data = $db->fetchAll("SELECT npc_name FROM public.npc_templates WHERE npc_name LIKE '%' || CHR(39) || '%'");
        
    foreach ($data as $n=>$element) {
        $currentName=$element["npc_name"];
        $codename=strtr(strtolower(trim($currentName)),[" "=>"_","'"=>"+"]);
        $codename=preg_replace('/[^a-zA-Z0-9_+]/u', '', $codename);
        
        $cn=$db->escape($codename);
        $on=$db->escape($currentName);
        $db->execQuery("update public.npc_templates set npc_name='$cn' where npc_name='$on'");

    }
    error_log("Silent npc_name patch applied");
}

$query = "SELECT 1 as bad_syntax_exists  FROM npc_templates_custom WHERE  npc_name LIKE '%' || CHR(39) || '%'";

$existsColumn=$db->fetchAll($query);
if ($existsColumn[0]["bad_syntax_exists"]) {
    $data = $db->fetchAll("SELECT npc_name FROM npc_templates_custom WHERE npc_name LIKE '%' || CHR(39) || '%'");
        
    foreach ($data as $n=>$element) {
        $currentName=$element["npc_name"];
        $codename=strtr(strtolower(trim($currentName)),[" "=>"_","'"=>"+"]);
        $cn=$db->escape($codename);
        $on=$db->escape($currentName);
        $db->execQuery("update npc_templates_custom set npc_name='$cn' where npc_name='$on'");

    }
    error_log("Silent npc_templates_custom patch applied");
}



$query = "select npc_name from npc_templates where npc_name='kishar'";
$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["npc_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/npc_kishar_update.sql"));
    echo '<script>alert("A patch (Kishar follower) has been applied to Database")</script>';
}



$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'oghma' AND column_name = 'native_vector'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/oghma_infinium2.sql"));
    echo '<script>alert("A patch (oghma_infinium 2) has been applied to Database")</script>';
}

$query = "
    SELECT column_name 
    FROM information_schema.columns 
    WHERE table_name = 'npc_templates' AND column_name = 'xvasynth_voiceid'
";

$existsColumn=$db->fetchAll($query);
if (!$existsColumn[0]["column_name"]) {
    $db->execQuery(file_get_contents(__DIR__."/../data/add_voiceid_to_templates.sql"));
    $db->execQuery('ALTER TABLE "npc_templates" ADD COLUMN "melotts_voiceid" text');
    $db->execQuery('ALTER TABLE "npc_templates" ADD COLUMN "xtts_voiceid" text');
    $db->execQuery('ALTER TABLE "npc_templates" ADD COLUMN "xvasynth_voiceid" text');
    $db->execQuery('ALTER TABLE "npc_templates_custom" ADD COLUMN "melotts_voiceid" text');
    $db->execQuery('ALTER TABLE "npc_templates_custom" ADD COLUMN "xtts_voiceid" text');
    $db->execQuery('ALTER TABLE "npc_templates_custom" ADD COLUMN "xvasynth_voiceid" text');

    $db->execQuery('insert into npc_templates select * from npc_templates_v2 where npc_name not in (select npc_name from npc_templates)');

    $db->execQuery('UPDATE "npc_templates" A SET "melotts_voiceid"=(select melotts_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');
    $db->execQuery('UPDATE "npc_templates" A SET "xtts_voiceid"=(select xtts_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');
    $db->execQuery('UPDATE "npc_templates" A SET "xvasynth_voiceid"=(select xvasynth_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');

    $db->execQuery('UPDATE "npc_templates_custom" A SET "melotts_voiceid"=(select melotts_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');
    $db->execQuery('UPDATE "npc_templates_custom" A SET "xtts_voiceid"=(select xtts_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');
    $db->execQuery('UPDATE "npc_templates_custom" A SET "xvasynth_voiceid"=(select xvasynth_voiceid from  npc_templates_v2 where npc_name=A.npc_name)');

    $db->execQuery(file_get_contents(__DIR__."/../data/add_voiceid_to_templates_2stage.sql"));

    echo '<script>alert("A patch (expanded npc table) has been applied to Database")</script>';
}

?>