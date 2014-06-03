<?php
    if (!function_exists('gzdecode')) {
        function gzdecode ($data) {
            $flags = ord(substr($data, 3, 1));
            $headerlen = 10;
            $extralen = 0;
             if ($flags & 4) {
                $ret = unpack('v' ,substr($data, 10, 2));
                $extralen = $ret[1];
                $headerlen += 2 + $extralen;
            }
            if ($flags & 8) // Filename
                $headerlen = strpos($data, chr(0), $headerlen) + 1;
            if ($flags & 16) // Comment
                $headerlen = strpos($data, chr(0), $headerlen) + 1;
            if ($flags & 2) // CRC at end of file
                $headerlen += 2;
            $unpacked = @gzinflate(substr($data, $headerlen));
            if ($unpacked === FALSE)
                $unpacked = $data;
            return $unpacked;
        }
    }
?>
