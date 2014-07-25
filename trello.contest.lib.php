<?php
$GLOBALS['nl']=(PHP_SAPI==='cli')?PHP_EOL:"<br/>";

	//**************************************************\\
	//													\\
	//						Utils						\\
	//													\\
	//													\\
	//**************************************************\\
	/**
	 * Function getGET
	 *
	 * Provides the HTTP GET value of a key
	 *
	 * @param (string) ($s) the key value
	 * @return (string) ($Theget) the value of the HTTP GET
	 */
	function getGET($s) {

		if (isset($_GET[$s]) && ! empty($_GET[$s])) {
			return $_GET[$s];
		}

		return null;
	}

	/**
	 * Function getPost
	 *
	 * Provides the HTTP POST value of a key
	 *
	 * @param (string) ($s) the key value
	 * @return (string) ($Theget) the value of the HTTP POST
	 */
	function getPost($s) {
		if (isset($_POST[$s]) && ! empty($_POST[$s])) {
			return $_POST[$s];
		}
		return null;
	}

	//**************************************************\\
	//													\\
	//		Front-end web developper challenge			\\
	//		https://trello.com/jobs/developer			\\
	//													\\
	//**************************************************\\
	/**
	 * Function hashThatString
	 *
	 * Provides the hash of a string following an algorythm based on a base37 converter with some salt
	 *
	 * @param (string) ($s) the string to hash
	 * @return (int) ($h) the hash
	 */
	function hashThatString($s) {
	    $h = 7; //int
	    $letters = "acdegilmnoprstuw"; //string
	    $length = strlen($s);
	    for($i = 0; $i < $length; $i++) {
	        $h = ($h * 37 + strpos($letters, $s[$i]));
	    }
	   	return $h;
	}	

	/**
	 * Function dehashThatString
	 *
	 * Provides the decoded string which has been encoded with hashThatString
	 * The algorythm is based on a base37 to Decimal converter and each mantissa is associated to a character
	 *
	 * @param (int) ($n) the hash of the string 
	 * @return (string) ($s) the string in clear
	 */
	function dehashThatString($n) {
		//fuck that base 37 conversion... functions stops at 36, crap !
		//the hash process starts at n then n-1... 0 (n=length of the string to hash)
		//at the nth position, we have a 7 as a key which is a "m"
		$base=37;
	    $letters = "acdegilmnoprstuw"; 
	    $h = 7; 
	    $s="";
	    $r=$n;
	    $p=0;
	    $q=$base;
        	echo $n .$GLOBALS['nl'];	
	    do {
	    	$p= floor($r / $q);
	    	echo "p=" .$p . " q=". $q . " r=". ($r - $p*$q) .$GLOBALS['nl'];
	    	$nr=(int)($r - $p*$q);
	    	$s=$letters[$nr] . $s;
	    	$r=($r-$nr)/$q;
    	} while ($p>0 || $r>0);
   	return substr($s, 1);
	}	

	//**************************************************\\
	//													\\
	//		Front-end web developper challenge			\\
	//	https://trello.com/jobs/front-end-developer		\\
	//		Execution time :  385.28652501106			\\
	//**************************************************\\
	/**
	 * Function decodeMessage
	 *
	 * Decode the message of the front-end web developper challenge:
	 *  1.  Find the pair of identical characters that are farthest apart, and contain
	 *  	no pairs of identical characters between them.  (e.g. for \"abcbba\" the 
	 *  	chosen characters should be the first and last b)
	 *  
	 *  	In the event of a tie, choose the left-most pair (e.g. for \"aabcbded\" the
	 *  	chosen characters should be the first and second \"b\")
	 *  
	 *  2.  Remove one of the characters in the pair, and move the other to the end of
	 *      the string.  (e.g. for \"abcbba\" you'd end up with \"acbab\")
	 *  
	 *  3.  Repeat steps 1 and 2 until no repeated characters remain
	 *  
	 *  4.  If the resulting string contains an underscore, remove it and any 
	 *      characters after it (e.g. \"abc_def\" would become \"abc\")
	 *  
	 *  5.  The remaining string is the answer.    
	 *  
	 *  see :
	 *  https://trello.com/jobs/front-end-developer
	 *  https://api.trello.com/1/boards/52f3feeb07e6f51c53f7ea4d/cards?fields=name,idList,url,desc&key=6e3df77c1f05d93cb5afa32ed468ce98&token=8233ec2524d1c48fcb44ac6c4371289d8e4418b5b64e42837ffb922ad2956eb0
	 *  
	 * @param (string) ($s) the string which has to be decoded
	 * @return (array) (theCandidate) an array which contains : the position of the 1st occurence, the position of the 2d occurence, the character, the distance between both occurences
	 */
	function decodeMessage($s) { //do it the sequential way.
		//echo $s . $GLOBALS['nl'];
		$s=str_replace("\r\n", "", $s);
		while(list($k,$l,$c,$d)=getCandidate($s)) {
			//echo "found : ".$c."(".$k.";".$l. ";".$d.")<br/>";	
			$s=substr_replace($s, "", $l, 1);
			$s=substr_replace($s, "", $k, 1);
			$s=$s .$c;
			//echo $s . $GLOBALS['nl'];
			echo "x";
		}

		//remove the chars after the _
		echo $GLOBALS['nl'];
		return strstr($s,"_",true)?strstr($s,"_",true):$s;
	}


	/**
	 * Function getCandidate
	 *
	 * Provides the pair of identical characters that are farthest apart, and contain no pairs of identical characters between them.
	 * Execution time : 0.7770779132843
	 * @param (string) ($s) the string which has to be searched
	 * @return (array) (theCandidate) an array which contains : the position of the 1st occurence, the position of the 2d occurence, the character, the distance between both occurences
	 */
	function getCandidate($s) {
		$dMax=0;
		$iMax=0;
		$jMax=0;
		$cMax="";
		$foundOne=false;

		for ($i=0;$i<strlen($s);$i++) { //from left of the string
			$j=$i;
			while(($j=strpos($s, $s[$i],$j+1))!==false) { //$s[$j] ==$s[$i] && $i<>$j 
				//echo $i."-".$j ."-".$dMax."<br>";
				if (($j-$i>$dMax) && ! isTherePairs(substr($s, $i+1,$j-$i-1))) { //no pair inside & distance is max
					$foundOne=true; //tell we foudn at least one. used for return
					$dMax=$j-$i;
					$iMax=$i;
					$jMax=$j;
					$cMax=$s[$i];
					//echo "new candidate : ".$cMax."(".$iMax.";".$jMax. ";".$dMax.")<br/>";
				}
			}
		} 
 		if ($foundOne) {return  array($iMax,$jMax,$cMax,$dMax);}
		return false;//array(null,null,null);
	}

	/**
	 * Function isTherePairs
	 *
	 * Tells if there are character duplicates in the string (orignal version)
	 *
	 * @param (string) ($s) the string which has to be checked
	 * @return (bool) (isTherePair) true if there is at least a pair of chars in the string
	 */
	function isTherePairs($s) {
		for ($i=0;$i<strlen($s);$i++) { //from left of the string
			if((strpos($s, $s[$i],$i+1) )!==false) { //find the farthest same char in the string 
				return true;
			} 
		}
		return false;
	}
?>