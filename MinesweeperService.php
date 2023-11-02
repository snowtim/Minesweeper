<?php
    class MinesweeperService {
        public $allCoordinateAry;
        public $userInputAry;

        public function __construct() {
            $this->allCoordinateAry = array();
            $this->userInputAry = [
                'select_coordinate_x' => -1,
                'select_coordinate_y' => -1
            ];
        }

        /**Generate all coordinate
         *
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $allCoordinateAry
         *
         **/
        public function generateAllCoordinate($allCoordinateAry, $mode){
            for($coordinateX = 1; $coordinateX <= $mode['range'][0]; $coordinateX++) {
                for ($coordinateY = 1; $coordinateY <= $mode['range'][1]; $coordinateY++) {
                    $allCoordinateAry[$coordinateX][$coordinateY] = 0;
                }
            }

            return $allCoordinateAry;
        }


        /**Decide mines' position
         *
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $normalAndMinesCoordinateData
         *
         **/
        public function decideMinesCoordinate($allCoordinateAry, $mode) {
            $mines = 0;
            while($mines < $mode['mines']) {
                $coordinateX = rand(1, $mode['range'][0]);
                $coordinateY = rand(1, $mode['range'][1]);
                if($allCoordinateAry[$coordinateX][$coordinateY] == 0) {
                    $allCoordinateAry[$coordinateX][$coordinateY] = -1;
                    $minesCoordinateAry[] = [
                        'mines_coordinate_x' => $coordinateX,
                        'mines_coordinate_y' => $coordinateY
                    ];
                    $mines++;
                }
            }

            $normalAndMinesCoordinateData = [
                'all_coordinate_ary' => $allCoordinateAry,
                'mines_coordinate_ary' => $minesCoordinateAry
            ];

            return $normalAndMinesCoordinateData;
        }

        /**Checkout number of mines around the all coordinate.
         *
         *@param array $allCoordinateAry
         *@param array $minesCoordinateAry
         *@param array $mode
         *
         *@return array $allCoordinateAry
         *
         **/
        public function accountNumberOfMinesAroundCenterCoordinate($allCoordinateAry, $minesCoordinateAry, $mode) {
            $numberOfMines = 0;

            for($coordinateX = 1; $coordinateX <= $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 1; $coordinateY <= $mode['range'][1]; $coordinateY++) {
                    if($allCoordinateAry[$coordinateX][$coordinateY] == 0) {
                        foreach($minesCoordinateAry as $minesCoordinate) {
                            $twoCoordinatesDistance =
                                pow($coordinateX-$minesCoordinate['mines_coordinate_x'],2) +
                                pow($coordinateY-$minesCoordinate['mines_coordinate_y'],2);
                            if($twoCoordinatesDistance == 1 || $twoCoordinatesDistance == 2) {
                                    $numberOfMines++;
                            }
                        }
                        $allCoordinateAry[$coordinateX][$coordinateY] = $numberOfMines;
                        $numberOfMines = 0;
                    }
                }
            }

            return $allCoordinateAry;
        }

        /**Composition of array that the coordinate user select
         *
         * @param array $userInputAry
         * @param array $mode
         *
         * @return array $userInputAry
         *
         **/
        public function userSelectCoordinate($userInputAry, $mode) {
            while(($userInputAry['select_coordinate_x'] > $mode['range'][0]) || $userInputAry['select_coordinate_x'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputAry['select_coordinate_x'] = (int)readline("Enter Coordinate X:");
            }

            while(($userInputAry['select_coordinate_y'] > $mode['range'][1]) || $userInputAry['select_coordinate_y'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputAry['select_coordinate_y'] = (int)readline("Enter Coordinate Y:");
            }

            return $userInputAry;
        }

        /**Check user's select if it is mine
         *
         * @param array $userInputAry
         * @param array $allCoordinateAry
         *
         * @return int
         **/
        public function gameOver($userInputAry, $allCoordinateAry) {
            if($allCoordinateAry[$userInputAry['select_coordinate_x']][$userInputAry['select_coordinate_y']] == -1) {
                return 0;
            }

            return 1;
        }

        /**Spread Area where has no mines
         *
         * @param array $userInputAry
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $allCoordinateAry
         *
         **/
        public function spreadSafeArea($userInputAry, $allCoordinateAry, $mode) {
            if($allCoordinateAry[$userInputAry['select_coordinate_x']][$userInputAry['select_coordinate_y']] == 0) {
                $allCoordinateAry[$userInputAry['select_coordinate_x']][$userInputAry['select_coordinate_y']] = 9;

                if(($userInputAry['select_coordinate_x'] - 1) > 0) {
                    $userInputAryXMinus = [
                        'select_coordinate_x' => $userInputAry['select_coordinate_x'] - 1,
                        'select_coordinate_y' => $userInputAry['select_coordinate_y']
                    ];
                    $allCoordinateAry = $this->spreadSafeArea($userInputAryXMinus, $allCoordinateAry, $mode);
                }
                if(($userInputAry['select_coordinate_y'] - 1) > 0) {
                    $userInputAryYMinus = [
                        'select_coordinate_x' => $userInputAry['select_coordinate_x'],
                        'select_coordinate_y' => $userInputAry['select_coordinate_y'] - 1
                    ];
                    $allCoordinateAry = $this->spreadSafeArea($userInputAryYMinus, $allCoordinateAry, $mode);
                }
                if(($userInputAry['select_coordinate_x'] + 1) < $mode['range'][0]) {
                    $userInputAryXIncrease = [
                        'select_coordinate_x' => $userInputAry['select_coordinate_x'] + 1,
                        'select_coordinate_y' => $userInputAry['select_coordinate_y']
                    ];
                    $allCoordinateAry = $this->spreadSafeArea($userInputAryXIncrease, $allCoordinateAry, $mode);
                }
                if(($userInputAry['select_coordinate_y'] + 1) < $mode['range'][1]) {
                    $userInputAryYIncrease = [
                        'select_coordinate_x' => $userInputAry['select_coordinate_x'],
                        'select_coordinate_y' => $userInputAry['select_coordinate_y'] + 1
                    ];
                    $allCoordinateAry = $this->spreadSafeArea($userInputAryYIncrease, $allCoordinateAry, $mode);
                }
            }

            return $allCoordinateAry;
        }

        /**Check how many area do not been opened.
         *
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return int $unopenedCoordinate
         *
         **/
        public function checkAllValueOfCoordinate($allCoordinateAry, $mode) {
            $unopenedCoordinate = 0;

            for($coordinateX = 1; $coordinateX <= $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 1; $coordinateY <= $mode['range'][1]; $coordinateY++) {
                    if($allCoordinateAry[$coordinateX][$coordinateY] == 0) {
                        $unopenedCoordinate++;
                    }
                }
            }

            return $unopenedCoordinate;
        }
    }