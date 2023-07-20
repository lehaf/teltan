<?define("BX_CRONTAB_SUPPORT", true);?><?define("BX_CRONTAB_SUPPORT", true);?><?php
define("BX_USE_MYSQLI", true);
$DBDebug = false;
$DBDebugToFile = false;

define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_FILE_PERMISSIONS", 0644);
define("BX_DIR_PERMISSIONS", 0755);
@umask(~(BX_FILE_PERMISSIONS | BX_DIR_PERMISSIONS) & 0777);

define("BX_DISABLE_INDEX_PAGE", true);

define("BX_UTF", true);
mb_internal_encoding("UTF-8");
session_start();
if($_REQUEST['lang'] != null) {
    $_SESSION["SESS_AUTH"]['LANG_UI'] = $_REQUEST['lang'];

}

if($_SESSION["SESS_AUTH"]['LANG_UI'] != null){
    define('LANGUAGE_ID',$_SESSION["SESS_AUTH"]['LANG_UI']);

}else{
    define('LANGUAGE_ID','he');
    $_SESSION["SESS_AUTH"]["LANG_UI"] = 'he';

}
