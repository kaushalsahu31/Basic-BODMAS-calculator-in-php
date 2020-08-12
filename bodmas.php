<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bodmas</title>
    <style>
        body{
    padding: 0;
    margin: 0; 
    height: 501px;
    background-color:rgb(77, 166, 255);
    }
    .main-div{
        background-color: rgb(187, 255, 51);
        width:40%;
        height: 60%;
        border-radius: 20px;
    }
    .main{
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    }
    form{
        display: flex;
        flex-direction: column;
        margin: 10px;
        width:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40%;
    }
    .form-input{
        margin: 5px 5px;
        background-color:rgba(255, 25, 25);
        color:white;
    }
    </style>
</head>
<body>
    <div class="main">
            <div class="main-div">
                <h1>BODMAS Calculator</h1>
            <form action="" method='POST'>
                <input type="text" name='bodmas' placeholder='Bodmas'>
                <br>
                <button class='form-input' name='submit' value='submit' type="submit">Submit</button>
            </form>
            <?php
                if (isset($_POST['submit'])){
                    $s=$_POST['bodmas'];
                    $newList = array();
                    $string='';
                    $j=0;
                    while($j<strlen($s)){
                        if ($s[$j] == "/" or $s[$j] == "*" or $s[$j] == "+" or $s[$j] == "-" or $s[$j] == "(" or $s[$j] == ")"){
                            if ($string!=""){
                                array_push($newList,$string);
                                array_push($newList,$s[$j]);
                                $string = '';
                            }
                            else{
                                array_push($newList,$s[$j]);
                            }
                        }
                        else{
                            $string.=$s[$j];
                        }
                        ++$j;
                    }
                    error_reporting (E_ALL ^ E_NOTICE);
                    if($string!=""){
                        array_push($newList,$string);
                    }
                    $check=1;
                    while($check<(sizeof($newList)-1)){
                        $insert='*';
                        if ($newList[$check]=="("){
                            if ($newList[$check-1]=="/" || $newList[$check-1]=="*" || $newList[$check-1]=="+" || $newList[$check-1]=="-" || $newList[$check-1]=="("){
                            }
                            else{
                                array_splice( $newList, $check, 0, $insert);
                                $check++;
                            }
                        }
                        if ($newList[$check]==")"){
                            if ($newList[$check+1]=="/" || $newList[$check+1]=="*" || $newList[$check+1]=="+" || $newList[$check+1]=="-" || $newList[$check+1]==")") {
                            }
                            else{
                                array_splice( $newList, $check+1, 0, $insert);
                                $check++;
                            }
                        }
                        $check++;
                    }

                    function check($key,$newList,$indexOfOpen){
                        if ($key=="/"){
                            $NewNumber=($newList[$indexOfOpen -1]) / ($newList[$indexOfOpen +1]);
                            $NewNumber=strval((int)$NewNumber);
                        }
                        elseif ($key=="*"){
                            $NewNumber=($newList[$indexOfOpen -1]) * ($newList[$indexOfOpen +1]);
                        }
                        elseif ($key=="+"){
                            $NewNumber=($newList[$indexOfOpen -1]) + ($newList[$indexOfOpen +1]);
                        }
                        elseif ($key=="-"){
                            $NewNumber=($newList[$indexOfOpen -1]) - ($newList[$indexOfOpen +1]);
                        }
                        return $NewNumber;
                    }
                    $operator=array("/","*","+","-");
                    while (in_array('(', $newList)) {
                        $indexOfClose=array_search(')',$newList);
                        $indexOfOpen=$indexOfClose;
                        while ($newList[$indexOfOpen]!='('){
                            --$indexOfOpen;
                        }
                        $refresh=$indexOfOpen;
                        if (($indexOfClose -$indexOfOpen) == 2){
                            unset($newList[$indexOfClose]);
                            unset($newList[$indexOfOpen]);
                            $newList = array_values($newList);
                        }
                        else{
                            foreach ($operator as $key) {
                                $indexOfOpen=$refresh;
                                while($indexOfOpen+1<$indexOfClose){
                                    if($newList[$indexOfOpen] == $key){
                                        $NewNumber = check($key,$newList,$indexOfOpen);
                                        unset($newList[$indexOfOpen+1]);
                                        unset($newList[$indexOfOpen]);
                                        $newList = array_values($newList);
                                        $newList[$indexOfOpen -1]=$NewNumber;
                                    }
                                    ++$indexOfOpen;
                                }
                            }
                        }
                    }
                    if(!in_array('(',$newList)){
                        if (sizeof($newList)>=3){
                            foreach ($operator as $key) {
                                $loop=0;
                                while($loop<(sizeof($newList)-1)){
                                    if ($newList[$loop] == $key){
                                        $NewNumber = check($key,$newList,$loop);
                                        unset($newList[$loop+1]);
                                        unset($newList[$loop]);
                                        $newList = array_values($newList);
                                        $newList[$loop -1]=$NewNumber;
                                        $loop=0;	
                                    }
                                    $loop++;
                                }
                            }
                        }
                    }
                    $printlist=$newList[0];
                    echo "<h3> your result:".$printlist."</h3>";
                }
            ?>
        </div>
    </div>
</body>
</html>