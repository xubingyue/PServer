<?php
    //点到线段的距离
    define('MAX_POINTS_NUM', 128);
    
    function dist($tx0, $ty0, $tx1, $ty1, $tpx, $tpy)
    {
        $x1 = $tx1 - $tx0;
        $y1 = $ty1 - $ty0;
        $px = $tpx - $tx0;
        $py = $tpy - $ty0;
        
        return (abs($y1 * $px - $x1 * $py) / sqrt($y1 * $y1 + $x1 * $x1));
    }
    
    //把路径按照区域分割为折线段
    function break_up_line($path, $minx, $maxx, $miny, $maxy)
    {
        $ret = array();
        $way = array();
        $first = true;
        for($i = 0; $i < count($path); ++$i)
        {
            if(($path[$i][1] >= $minx) && ($path[$i][1] < $maxx) && ($path[$i][2] >= $miny) && ($path[$i][2] < $maxy))
            {
                if($first)
                {
                    if($i - 1 >= 0)
                    {
                        array_push($way, $path[$i - 1]);
                    }                    
                }
                array_push($way, $path[$i]);
                $first = false;
            }
            else
            {
                if(!$first)
                {
                    $first = true;
                    array_push($way, $path[$i]);
                    if(count($way) > 0)
                    {
                        array_push($ret, $way);
                        $way = array();
                    }
                }
            }
        }
        
        if(count($way) > 0)
        {
            array_push($ret, $way);
            $way = array();
        }
        
        return $ret;
    }
    
    //进行点的拟合
    function fitting($ret, $limit)
    {
        $path = array();
        if(count($ret) > 0)
        {
            array_push($path, $ret[0]);
        }
        $i = 0;
        
        for(; $i < count($ret);)
        {
            for($j = $i + 1; ($j < $i + 4) && ($j < count($ret)); ++$j)
            {
                $max = 0;
                for($k = $i + 1; $k < $j; ++$k)
                {
                    $d = dist($ret[$i][1], $ret[$i][2], $ret[$j][1], $ret[$j][2], $ret[$k][1], $ret[$k][2]);
                    if($d > $max)
                    {
                        $max = $d;
                    }
                }
                if($max > $limit)
                {
                    --$j;
                    break;            
                }            
            }
            if($j < count($ret))
            {
                array_push($path, $ret[$j]);
            }
            else if(count($ret) - 1 > 0)
            {
                array_push($path, $ret[count($ret) - 1]);
            }
            $i = $j;
        }
        
        return $path;
    }
    
    //对指定举行范围内的曲线进行拟合, 最多返回128个点
    function fix_line($ret, $minx, $maxx, $miny, $maxy)
    {
        //首先按照显示区间把折线分割。
        $path = break_up_line($ret, $minx, $maxx, $miny, $maxy);
        $dx = $maxx - $minx;
        $dy = $maxy - $miny;
        $limit = sqrt($dx * $dx + $dy * $dy) / (MAX_POINTS_NUM * 7);
        
        //设置最初的结果
        $result = $path;
        $last_total = -1;
        $times = 1;
        while(true)
        {
            //判断是否需要进行拟合, 如果小于100个点就不需要进行拟合
            $total = 0;
            foreach($result as $way)
            {
                $total += count($way);                
            }
            if($total <= MAX_POINTS_NUM)
            {
                break;            
            }
            if($total == $last_total)
            {
                if($times < 10)
                {
                    $limit = $limit * 1.2;
                }
                else
                {
                    $limit = $limit * 2;
                }
            }
            else
            {
                $limit = $limit * 0.8;
            }
            $last_total = $total;
            
            //进行一次拟合
            $new_result = array();
            foreach($result as $way)
            {
                array_push($new_result, fitting($way, $limit));
            }
            $result = $new_result;            
            ++$times;
        }
        return $result;
    }
?>
