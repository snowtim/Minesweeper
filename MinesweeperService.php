<?php

    /**
     * Class MniesweeperService
     */
    class MinesweeperService {
        public $mines;
        public $coordinateAry;
        public $userInputAry;

        public function __construct() {
            $this->mines = 0;
            $this->coordinateAry = array();
            $this->userInputAry = [
                'user_input_coordinate_X' => -1,
                'user_input_coordinate_Y' => -1
            ];
        }

        /**
         * Generate coordinate
         *
         * @param array $coodinateAry
         * @param array $mode
         *
         * @return array $coodinateAry
         */
        public function generateAllCoordinatesBySelectMode($coordinateAry, $mode) {
            for($coordinateX = 0; $coordinateX < $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 0; $coordinateY < $mode['range'][1]; $coordinateY++) {
                    $coordinateAry[] = [
                        'coordinate_X' => $coordinateX,
                        'coordinate_Y' => $coordinateY,
                        'mine' => 0,
                        'safe_coordinate' => -1,
                        'mines_around' => 0
                    ];
                }
            }

            return $coordinateAry;
        }

        /**
         * Decide where mines' position
         *
         * @param       $mines
         * @param array $coordinateAry
         * @param array $mode
         *
         * @return array $coordinateAry
         */
        public function decideMinesCoordinate($mines, $coordinateAry, $mode) {
            while($mines < $mode['mines']) {
                $allRange = $mode['range'][0] * $mode['range'][1];
                $randomCoordinate = mt_rand(0, $allRange-1);

                if($coordinateAry[$randomCoordinate]['mine'] == 0) {
                    $coordinateAry[$randomCoordinate]['mine'] = 1;
                    $coordinateAry[$randomCoordinate]['safe_coordinate'] = 0;
                    $mines++;
                }
            }

            return $coordinateAry;
        }

        /**
         * Composition of array that the position user select
         *
         * @param array $userInputAry
         * @param array $mode
         *
         * @return array $userInputAry
         */
        public function userSelectCoordinate($userInputAry, $mode) {
            while(($userInputAry['user_input_coordinate_X'] > $mode['range'][0] - 1) || $userInputAry['user_input_coordinate_X'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $userInputAry['user_input_coordinate_X'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($userInputAry['user_input_coordinate_Y'] > $mode['range'][1] - 1) || $userInputAry['user_input_coordinate_Y'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $userInputAry['user_input_coordinate_Y'] = (int)readline("Enter Coordinate Y:")-1;
            }

            return $userInputAry;
        }

        /**
         * check number of mines around the position user select
         *
         * @param array $userInputAry
         * @param array $coodinateAry
         * @param array $mode
         *
         * @return array $coordinateAry
         */
        public function checkNumberOfMines ($userInputAry, $coordinateAry, $mode) {
            $numberOfMines = 0;
            $userInputCoordinateX = $userInputAry['user_input_coordinate_X'];
            $userInputCoordinateY = $userInputAry['user_input_coordinate_Y'];
            $coordinateTurnToKey =
                ($mode['range'][1] - 1) * $userInputCoordinateX + $userInputCoordinateX + $userInputCoordinateY;
            $minesCoordinateAry = array_keys(array_column($coordinateAry, 'mine'),1);

            foreach($minesCoordinateAry as $minesCoordinate) {
                $squareOfDistance =
                    pow($userInputCoordinateX - $coordinateAry[$minesCoordinate]['coordinate_X'], 2) +
                    pow($userInputCoordinateY - $coordinateAry[$minesCoordinate]['coordinate_Y'], 2);

                if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                    $numberOfMines++;
                }
            }

            $coordinateAry[$coordinateTurnToKey]['mines_around'] = $numberOfMines;

            return $coordinateAry;
        }

        /**
         * Checkout coordinate where safe is.
         *
         * @param array $userInputAry
         * @param array $coordinateAry
         * @param array $mode
         *
         * @return array $coordinateAry
         */
        public function checkoutSafeCoordinate ($userInputAry, $coordinateAry, $mode) {
            $userInputCoordinateX = $userInputAry['user_input_coordinate_X'];
            $userInputCoordinateY = $userInputAry['user_input_coordinate_Y'];

            //The array of user select coordinate and coordinates around.
            $minusCoordinateX = max(($userInputCoordinateX - 1), 0);
            $minusCoordinateY = max(($userInputCoordinateY - 1), 0);
            $positionCoordinateX = min(($userInputCoordinateX + 1), ($mode['range'][0] - 1));
            $positionCoordinateY = min(($userInputCoordinateY + 1), ($mode['range'][1] - 1));

            $coordinateAroundInputAry = [
                0 => [
                    'coordinate_X' => $userInputCoordinateX,
                    'coordinate_Y' => $userInputCoordinateY
                ],
                1 => [
                    'coordinate_X' => $minusCoordinateX,
                    'coordinate_Y' => $minusCoordinateY
                ],
                2 => [
                    'coordinate_X' => $userInputCoordinateX,
                    'coordinate_Y' => $minusCoordinateY
                ],
                3 => [
                    'coordinate_X' => $positionCoordinateX,
                    'coordinate_Y' => $minusCoordinateY
                ],
                4 => [
                    'coordinate_X' => $minusCoordinateX,
                    'coordinate_Y' => $userInputCoordinateY
                ],
                5 => [
                    'coordinate_X' => $positionCoordinateX,
                    'coordinate_Y' => $userInputCoordinateY
                ],
                6 => [
                    'coordinate_X' => $minusCoordinateX,
                    'coordinate_Y' => $positionCoordinateY
                ],
                7 => [
                    'coordinate_X' => $userInputCoordinateX,
                    'coordinate_Y' => $positionCoordinateY
                ],
                8 => [
                    'coordinate_X' => $positionCoordinateX,
                    'coordinate_Y' => $positionCoordinateY
                ]
            ];

            foreach ($coordinateAroundInputAry as $coordinate) {
                $coordinateTurnToKey =
                    ($mode['range'][1] - 1) * $coordinate['coordinate_X'] + $coordinate['coordinate_X'] + $coordinate['coordinate_Y'];

                if($coordinateAry[$coordinateTurnToKey]['mine'] == 1) {
                    continue;
                }

                if($coordinateAry[$coordinateTurnToKey]['safe_coordinate'] == 1) {
                    continue;
                }

                $coordinateAry[$coordinateTurnToKey]['safe_coordinate'] = 1;
                $userInputAry['user_input_coordinate_X'] = $coordinate['coordinate_X'];
                $userInputAry['user_input_coordinate_Y'] = $coordinate['coordinate_Y'];
                $coordinateAry = $this->checkNumberOfMines($userInputAry, $coordinateAry, $mode);
                //echo $coordinateAry[$coordinateTurnToKey]['mines_around'];
                if($coordinateAry[$coordinateTurnToKey]['mines_around'] == 0) {
                    return $this->checkoutSafeCoordinate($userInputAry, $coordinateAry, $mode);
                }
            }

            return $coordinateAry;
        }

        /**
         * Return param to decide the game is over or not.
         *
         * @param array $userInputAry
         * @param array $coordinateAry
         * @param array $mode
         *
         * @return int $gameOver
         */
        public function gameOver($userInputAry, $coordinateAry, $mode) {
            $coordinateTurnToKey =
                ($mode['range'][1] - 1) * $userInputAry['user_input_coordinate_X'] + $userInputAry['user_input_coordinate_X'] + $userInputAry['user_input_coordinate_Y'];

            if($coordinateAry[$coordinateTurnToKey]['mine'] == 1) {
                echo "You Died"."\n";
                //$gameOver = 1;
                return $gameOver = 1;
            }

            //$gameOver = 0;
            return $gameOver = 0;
        }
    }


