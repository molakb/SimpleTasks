<?php
  /* Read input from STDIN. Print your output to STDOUT*/
  $fp = fopen("php://stdin", "r");
  fscanf($fp, "%d\n", $numTestCases);
  $i = 0;
  while($i < $numTestCases){
      $line = fgets($fp);
      $testCase = explode(' ',$line);
      $testCase[] = readTestCase($testCase[1],$fp);
      $testCases[$i] = $testCase;
      $i++;
  }
  
  $i = 0;
  while($i < $numTestCases){
    $maxCost = 0;
    $j = 1;
    while($j <= $testCases[$i][0]){
        $totalCost = 0;
        $visitedShopArr = array();
        $paths = $testCases[$i][2];
        $visitedShopArr[] = $j;
        $prevShop = $j;
        $currentShop = $j;
     
        while(count($visitedShopArr) != $testCases[$i][0]){
            $calcShopCost = getAllPathCost($paths,$prevShop,$currentShop,$visitedShopArr);
            if(count($calcShopCost[0]) == 0 && count($calcShopCost[0]) == 0){
                break;
            }
            if(max($calcShopCost[0]) > max($calcShopCost[1])){
                $maxPath = getMaxPathShop($paths,$prevShop,$visitedShopArr);
                $totalCost += $paths[$maxPath][2];
                $visitedShopArr[] = $paths[$maxPath][0] != $prevShop ? $paths[$maxPath][0] : $paths[$maxPath][1];
                $currentShop = $paths[$maxPath][0] != $prevShop ? $paths[$maxPath][0] : $paths[$maxPath][1];
            }else {
                $maxPath = getMaxPathShop($paths,$currentShop,$visitedShopArr);
                $totalCost += $paths[$maxPath][2];
                $visitedShopArr[] = $paths[$maxPath][0] != $currentShop ? $paths[$maxPath][0] : $paths[$maxPath][1];
                $prevShop = $currentShop; 
                $currentShop = $paths[$maxPath][0] != $currentShop ? $paths[$maxPath][0] : $paths[$maxPath][1];
            }
        }
        if($maxCost < $totalCost){
            $maxCost = $totalCost;
        }
        $j++;
    }

    echo $maxCost."\n";
    $i++;
  }      
  
  function getMaxPathShop($paths,$shop,$visitedShopArr){
      $max = 0;
      $pathindex = 0;
      foreach ($paths as $key => $value) {
         if(($shop == $value[0] && !in_array($value[1],$visitedShopArr))  || ($shop == $value[1] && !in_array($value[0],$visitedShopArr))){
              if($max < $value[2]){
                  $max = $value[2];
                  $pathindex = $key;
              }
          }
      }
      return $pathindex;
  }
  
  function getAllPathCost($paths,$prevShop,$currentShop,$visitedShopArr){
      
      $prevShopPathCostArr = array();
      $currentShopPathCostArr = array();
      foreach ($paths as $key => $value) {
          if(($prevShop == $value[0] && !in_array($value[1],$visitedShopArr))  || ($prevShop == $value[1] && !in_array($value[0],$visitedShopArr))){
            $prevShopPathCostArr[] = $value[2];
          }
          
          if(($currentShop == $value[0] && !in_array($value[1],$visitedShopArr)) || ($currentShop == $value[1] && !in_array($value[0],$visitedShopArr))){
            $currentShopPathCostArr[] = $value[2];
          }
      }
      return array($prevShopPathCostArr,$currentShopPathCostArr);
  }
  
  function readTestCase($numPths,$fp){
     $paths = array();
     $i = 0;
     while($i < $numPths){
        $line = fgets($fp);
        $i++;
        $paths[] = array_map("intval",explode(' ',$line));
    }   
    return $paths;
  }
?>
