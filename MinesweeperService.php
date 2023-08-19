<?php
    class MinesweeperService {
        public $minesCoordinateArr;
        public $userInputArr;
        public $checkedCoordinateArr;

        public function __construct() {
            //$this->mines = 0;
            $this->minesCoordinateArr = array();
            $this->userInputArr = [
                'selectCoordinate' => "",
                'selectCoordinateX' => -1,
                'selectCoordinateY' => -1
                ];
            $this->checkedCoordinateArr = array();
        }

        //Decide where mines' position
        public function decideMinesCoordinate($minesCoordinateArr, $mode) {
            while($mode['mines'] > 0) {
                $minesCoordinateX = mt_rand(0, $mode['range'][0] - 1);
                $minesCoordinateY = mt_rand(0, $mode['range'][1] - 1);
                $minesTemporaryCoordinate = "$minesCoordinateX,$minesCoordinateY";

                if(!in_array($minesTemporaryCoordinate, $minesCoordinateArr)) {
                    $minesCoordinateArr[] = $minesTemporaryCoordinate;
                    $mode['mines']--;
                }
            }

            sort($minesCoordinateArr);

            return $minesCoordinateArr;
        }

        //Composition of array that the position user select
        public function userSelectCoordinate($userInputArr, $mode) {
            while(($userInputArr['selectCoordinateX'] > $mode['range'][0] - 1) || $userInputArr['selectCoordinateX'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputArr['selectCoordinateX'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($userInputArr['selectCoordinateY'] > $mode['range'][1] - 1) || $userInputArr['selectCoordinateY'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputArr['selectCoordinateY'] = (int)readline("Enter Coordinate Y:")-1;
            }

            $userInputArr['selectCoordinate'] = $userInputArr['selectCoordinateX'].",".$userInputArr['selectCoordinateY'];

            return $userInputArr;
        }

        //check number of mines around the position user select
        public function checkNumberOfMines ($userInputArr, $minesCoordinateArr) {
            if(in_array($userInputArr['selectCoordinate'], $minesCoordinateArr)) {
                echo "You Died"."\n";
                return;
            }

            $numberOfMines = 0;

            foreach ($minesCoordinateArr as $coordinates) {
                $coordinatesX = explode(",", $coordinates)[0];
                $coordinatesY = explode(",", $coordinates)[1];

                //calculate distance between mines and the position user select
                $squareOfDistance =
                    pow($userInputArr['selectCoordinateX'] - $coordinatesX, 2) +
                    pow($userInputArr['selectCoordinateY'] - $coordinatesY, 2);
                if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                    $numberOfMines++;
                }
            }

            return $numberOfMines;
        }

        public function checkedArea($userInputArr, $minesCoordinateArr, $checkedCoordinateArr, $mode) {
            if(in_array($userInputArr['selectCoordinate'], $minesCoordinateArr)) {
                return $checkedCoordinateArr;
            }

            $minusCoordinateX = ($userInputArr['selectCoordinateX'] - 1) < 0 ? 0 : ($userInputArr['selectCoordinateX'] - 1);
            $minusCoordinateY = ($userInputArr['selectCoordinateY'] - 1) < 0 ? 0 : ($userInputArr['selectCoordinateY'] - 1);
            $positionCoordinateX =
                ($userInputArr['selectCoordinateX']+1) >= ($mode['range'][0]-1) ? $mode['range'][0]-1 : ($userInputArr['selectCoordinateX']+1);
            $positionCoordinateY =
                ($userInputArr['selectCoordinateY']+1) >= ($mode['range'][1]-1) ? $mode['range'][1]-1 : ($userInputArr['selectCoordinateY']+1);

            $checkedCoordinateTempArr = array_unique([
                0 => $minusCoordinateX . "," . $minusCoordinateY,
                1 => ($userInputArr['selectCoordinateX']) . "," . $minusCoordinateY,
                2 => $positionCoordinateX . "," . $minusCoordinateY,
                3 => $minusCoordinateX . "," . ($userInputArr['selectCoordinateY']),
                4 => $userInputArr['selectCoordinate'],
                5 => $positionCoordinateX . "," . $userInputArr['selectCoordinateY'],
                6 => $minusCoordinateX . "," . $positionCoordinateY,
                7 => ($userInputArr['selectCoordinateX']) . "," . $positionCoordinateY,
                8 => $positionCoordinateX . "," . $positionCoordinateY
            ]);

            if(array_diff($checkedCoordinateTempArr, $minesCoordinateArr)) {
                $checkedCoordinateTempArr = array_diff($checkedCoordinateTempArr, $minesCoordinateArr);

                if(array_diff($checkedCoordinateTempArr, $checkedCoordinateArr)) {
                    $tempDiffWithChecked = array_diff($checkedCoordinateTempArr, $checkedCoordinateArr);

                    foreach($tempDiffWithChecked as $tempDiffWithCheckedCoordinate) {
                        $checkedCoordinateArr[] = $tempDiffWithCheckedCoordinate;
                    }
                }
            }

            return $checkedCoordinateArr;
        }
    }