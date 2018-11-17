<?php 
/**
 * Date 17/11/2018
 * @author Piotr Walczak
 *
 * Znajduje najdłuższy wspólny podciąg znaków będący palindromem w podanym ciągu znaków.
 *
 * Złożoność czasowa - O(n2)
 *
 */

class LongestPalindromicSubsequence {
    public $longestCommonSub = '';

    public function compute($str) {
      
        $length = strlen($str);
        if($length == 1){
            $this->longestCommonSub = $str;
            return 1;
        }
        if($length == 0){
            return 0;
        }
        for($i=0; $i < $length; $i++){
            $T[$i][$i] = 1;
        }
    
        for($l = 2; $l <= $length; $l++){
            for($i = 0; $i < $length-$l + 1; $i++){
                $j = $i + $l - 1;
                if($l == 2 && $str[$i] == $str[$j]){
                    $T[$i][$j] = 2;
                }else if($str[$i] == $str[$j]){
                    $T[$i][$j] = $T[$i + 1][$j-1] + 2;
                }else{
                    $T[$i][$j] = max($T[$i + 1][$j], $T[$i][$j - 1]);
                }
            }
        }
        $this->longestCommonSub = $this->getLongestSubstring($str, $T);
        return $T[0][$length-1];
    }


    public function computeRecursive($str, $start, $len){
        if($len == 1){
            return 1;
        }
        if($len == 0){
            return 0;
        }
        if($str[$start] == $str[$start+$len-1]){
            return 2 + $this->computeRecursive($str,$start+1,$len-2);
        }else{
            return max($this->computeRecursive($str, $start+1, $len-1), $this->computeRecursive($str, $start, $len-1));
        }
    }

    public function getLongestSubstring($str, $T) {
        $len = 0;
        $length = strlen($str);
        $j = $length - 1;
        $i = 0;
        $lcp = array_fill(0, $length, '');
        if ($length === 0) {
            return '';
        }
        else if ($length === 1) {
            return $str;
        } else {
            do {
                if (($i+1) < $length && ($j-1) >= 0 && $i <= $j) {
                    // if value greater than both diagonals, then save value and move diagonally downwords
                    if ($T[$i][$j] > $T[$i][$j-1] && $T[$i][$j] > $T[$i+1][$j]) {
                        $lcp[$i] = $str[$i];
                        $lcp[$j] = $str[$j];
                        --$j;
                        ++$i;
                    // bottom value is the greates or equal
                    } else if ($T[$i][$j] >= $T[$i+1][$j] && $T[$i+1][$j] >= $T[$i][$j-1]) {
                        ++$i;
                    // left is the greates or equal
                    } else if ($T[$i][$j] >= $T[$i][$j-1] && $T[$i][$j-1] >= $T[$i+1][$j]) {
                        --$j;
                    } 
                } else {
                    break;
                }
                
            } while ($i !== $j);
            $lcp[$i] = $str[$i];
        }
        return implode('', $lcp);
    }
    
    public function init(){
        $str = stream_get_line(STDIN, 20000000000, PHP_EOL);
        // $start = microtime(true);
        // $r1 = $this->computeRecursive($str, 0, strlen($str));
        // $time_elapsed_secs = microtime(true) - $start;

        $start = microtime(true);
        $r2 = $this->compute($str);
        $time_elapsed_secs1 = microtime(true) - $start;

        //echo "Wynik computeRecursive - ${r1} czas wykonania - ${time_elapsed_secs} sek." . PHP_EOL;
        echo "Wynik compute - ${r2} czas wykonania - ${time_elapsed_secs1} sek." . PHP_EOL;
        echo "Najdluższy znaleziony palindrom: $this->longestCommonSub" .PHP_EOL;
    }    
}

$lps = new LongestPalindromicSubsequence();
$lps->init();