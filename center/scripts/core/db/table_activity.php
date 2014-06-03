<?php
    final class DB_TABLE_ACTIVITY
    {
        static public function create_activity($xml)
        {
                $data = array();
                $data['xml'] = $xml;
                $data['time'] = new MongoDate(time());
                return $data;
        }
    }
?>
