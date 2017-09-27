<?php 
function smarty_function_queryinfo($paramer,&$smarty){
	global $db;
    if (PHP_VERSION >= '5.0.0'){
        $query_time = number_format(microtime(true) - $db->queryTime, 6);
    }else{
        list($now_usec, $now_sec)     = explode(' ', microtime());
        list($start_usec, $start_sec) = explode(' ', $db->queryTime);
        $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
    }
    if (function_exists('memory_get_usage')){
        $memory_usage = '��ռ���ڴ� '.(memory_get_usage() / 1048576).' MB';
    }else{
        $memory_usage = '';
    }
    /*foreach($db->querySQLList as $k){
        $QuerySQL[]=
    }*/
    $QuerySQL=implode('<br/>',$db->querySQLList);
    //echo '��ִ�� '.$db->queryCount.' ����ѯ����ʱ '.$query_time.' �룬���� 1 �ˣ�Gzip �ѽ��ã�ռ���ڴ� 3.269 MB';
    echo '��ִ�� '.$db->queryCount.' ����ѯ����ʱ '.$query_time.' ��'.$memory_usage.'<br/>'.$QuerySQL;
}
?>