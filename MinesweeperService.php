<?php
    class MinesweeperService {
        public $mines;
        public $coordinateAry;
        public $userInputAry;

        public function __construct() {
            $this->mines = 0;
            $this->coordinateAry = array();
            $this->userInputAry = [
                'userInputCoordinateX' => -1,
                'userInputCoordinateY' => -1
            ];
        }

        //Generate coordinate
        public function generateAllCoordinatesBySelectMode($coordinateAry, $mode) {
            for($coordinateX = 0; $coordinateX < $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 0; $coordinateY < $mode['range'][1]; $coordinateY++) {
                    $coordinateAry[$coordinateX][$coordinateY] = [
                        'mine' => 0,
                        'checked' => 0
                    ];
                }
            }

            return $coordinateAry;
        }

        //Decide where mines' position
        public function decideMinesCoordinate($mines, $coordinateAry, $mode) {
            while($mines < $mode['mines']) {
                $coordinateX = mt_rand(0, $mode['range'][0] - 1);
                $coordinateY = mt_rand(0, $mode['range'][1] - 1);
                $coordinateAry[$coordinateX][$coordinateY]['mine'] = 1;

                $mines++;
            }

            return $coordinateAry;
        }

        //Composition of array that the position user select
        public function userSelectCoordinate($userInputAry, $mode) {
            while(($userInputAry['userInputCoordinateX'] > $mode['range'][0] - 1) || $userInputAry['userInputCoordinateX'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputAry['userInputCoordinateX'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($userInputAry['userInputCoordinateY'] > $mode['range'][1] - 1) || $userInputAry['userInputCoordinateY'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputAry['userInputCoordinateY'] = (int)readline("Enter Coordinate Y:")-1;
            }

            return $userInputAry;
        }

        //check number of mines around the position user select
        /*public function checkNumberOfMines ($userInputAry, $coordinateAry) {
            $userInputCoordinateX = $userInputAry['userInputCoordinateX'];
            $userInputCoordinateY = $userInputAry['userInputCoordinateY'];

            if($coordinateAry[$userInputCoordinateX][$userInputCoordinateY]['mine'] == 1]) {
                echo "You Died"."\n";
                return;
            }

            $numberOfMines = 0;



            $minusCoordinateX = max(($userInputArr['selectCoordinateX'] - 1), 0);
            $minusCoordinateY = max(($userInputArr['selectCoordinateY'] - 1), 0);
            $positionCoordinateX =
                ($userInputArr['selectCoordinateX']+1) >= ($mode['range'][0]-1) ? $mode['range'][0]-1 : ($userInputArr['selectCoordinateX']+1);
            $positionCoordinateY =
                ($userInputArr['selectCoordinateY']+1) >= ($mode['range'][1]-1) ? $mode['range'][1]-1 : ($userInputArr['selectCoordinateY']+1);

            foreach ($minesCoordinate as $coordinates) {
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
        }*/
    }