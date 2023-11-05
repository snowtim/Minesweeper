<?php

    /**
     * Class MinesweeperService
     */
    class MinesweeperService {
        //public $mines;
        public $allCoordinateAry;
        public $targetCoordinateAry;

        public function __construct() {
            //$this->mines = 0;
            $this->allCoordinateAry = array();
            $this->targetCoordinateAry = [
                'target_coordinate_X' => -1,
                'target_coordinate_Y' => -1
            ];
        }

        /**
         * Generate all coordinate
         *
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $allCoordinateAry
         */
        public function generateAllCoordinatesBySelectMode(array $allCoordinateAry, array $mode): array
        {
            for($coordinateX = 0; $coordinateX < $mode['range'][0]; $coordinateX++) {
                for($coordinateY = 0; $coordinateY < $mode['range'][1]; $coordinateY++) {
                    $allCoordinateAry[] = [
                        'coordinate_X' => $coordinateX,
                        'coordinate_Y' => $coordinateY,
                        'mine' => 0,
                        'safe_coordinate' => -1,
                        'mines_around' => 0
                    ];
                }
            }

            return $allCoordinateAry;
        }

        /**
         * Decide where mines' position
         *
         * @param int   $mines
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $allCoordinateAry
         */
        public function decideMinesCoordinate(array $allCoordinateAry, array $mode): array
        {
            $mines = 0;

            while($mines < $mode['mines']) {
                $allRange = $mode['range'][0] * $mode['range'][1];
                $randomMinesCoordinate = mt_rand(0, $allRange-1);

                if($allCoordinateAry[$randomMinesCoordinate]['mine'] == 0) {
                    $allCoordinateAry[$randomMinesCoordinate]['mine'] = 1;
                    $allCoordinateAry[$randomMinesCoordinate]['safe_coordinate'] = 0;
                    $mines++;
                }
            }

            return $allCoordinateAry;
        }

        /**
         * Composition of array that the position user select
         *
         * @param array $targetCoordinateAry
         * @param array $mode
         *
         * @return array $targetCoordinateAry
         */
        public function userSelectCoordinate(array $targetCoordinateAry, array $mode): array
        {
            while(($targetCoordinateAry['target_coordinate_X'] > $mode['range'][0] - 1) || $targetCoordinateAry['target_coordinate_X'] < 0) {
                echo "X value must between 1~".$mode['range'][0]."\n";
                $targetCoordinateAry['target_coordinate_X'] = (int)readline("Enter Coordinate X:")-1;
            }

            while(($targetCoordinateAry['target_coordinate_Y'] > $mode['range'][1] - 1) || $targetCoordinateAry['target_coordinate_Y'] < 0) {
                echo "Y value must between 1~".$mode['range'][1]."\n";
                $targetCoordinateAry['target_coordinate_Y'] = (int)readline("Enter Coordinate Y:")-1;
            }

            return $targetCoordinateAry;
        }

        /**
         * check number of mines around the position user select
         *
         * @param array $targetCoordinateAry
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $coordinateAry
         */
        public function checkNumberOfMines (array $targetCoordinateAry, array $allCoordinateAry, array $mode): array
        {
            $numberOfMines = 0;
            $targetCoordinateX = $targetCoordinateAry['target_coordinate_X'];
            $targetCoordinateY = $targetCoordinateAry['target_coordinate_Y'];
            $coordinateTurnToKey =
                ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $targetCoordinateY;
            $minesCoordinateAry = array_keys(array_column($allCoordinateAry, 'mine'),1);

            foreach($minesCoordinateAry as $minesCoordinate) {
                $squareOfDistance =
                    pow($targetCoordinateX - $allCoordinateAry[$minesCoordinate]['coordinate_X'], 2) +
                    pow($targetCoordinateY - $allCoordinateAry[$minesCoordinate]['coordinate_Y'], 2);

                if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                    $numberOfMines++;
                }
            }

            $allCoordinateAry[$coordinateTurnToKey]['mines_around'] = $numberOfMines;

            return $allCoordinateAry;
        }

        /**
         * Checkout coordinate where safe is.
         *
         * @param array $targetCoordinateAry
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return array $allCoordinateAry
         */
        public function checkoutSafeCoordinate (array $targetCoordinateAry, array $allCoordinateAry, array $mode): array
        {
            $targetCoordinateX = $targetCoordinateAry['target_coordinate_X'];
            $targetCoordinateY = $targetCoordinateAry['target_coordinate_Y'];
            $coordinateTurnToKey =
                ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $targetCoordinateY;
            $allCoordinateAry = $this->checkNumberOfMines($targetCoordinateAry, $allCoordinateAry, $mode);
            $allCoordinateAry[$coordinateTurnToKey]['safe_coordinate'] = 1;

            $minusCoordinateX = max(($targetCoordinateX - 1), 0);
            $coordinateTurnToKeyMinusX =
                ($mode['range'][1] - 1) * $minusCoordinateX + $minusCoordinateX + $targetCoordinateY;

            $minusCoordinateY = max(($targetCoordinateY - 1), 0);
            $coordinateTurnToKeyMinusY =
                ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $minusCoordinateY;

            $increaseCoordinateX = min(($targetCoordinateX + 1), ($mode['range'][0] - 1));
            $coordinateTurnToKeyIncreaseX =
                ($mode['range'][1] - 1) * $increaseCoordinateX + $increaseCoordinateX + $targetCoordinateY;

            $increaseCoordinateY = min(($targetCoordinateY + 1), ($mode['range'][1] - 1));
            $coordinateTurnToKeyIncreaseY =
                ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $increaseCoordinateY;

            if($allCoordinateAry[$coordinateTurnToKey]['mines_around'] == 0) {
                if($allCoordinateAry[$coordinateTurnToKeyMinusX]['safe_coordinate'] == -1 && $allCoordinateAry[$coordinateTurnToKeyMinusX]['mine'] == 0) {
                    $targetCoordinateAryMinusX = [
                        'target_coordinate_X' => $minusCoordinateX,
                        'target_coordinate_Y' => $targetCoordinateAry['target_coordinate_Y']
                    ];
                    $allCoordinateAry = $this->checkoutSafeCoordinate($targetCoordinateAryMinusX, $allCoordinateAry, $mode);
                }

                if($allCoordinateAry[$coordinateTurnToKeyMinusY]['safe_coordinate'] == -1 && $allCoordinateAry[$coordinateTurnToKeyMinusY]['mine'] == 0) {
                    $targetCoordinateAryMinusY = [
                        'target_coordinate_X' => $targetCoordinateAry['target_coordinate_X'],
                        'target_coordinate_Y' => $minusCoordinateY
                    ];
                    $allCoordinateAry = $this->checkoutSafeCoordinate($targetCoordinateAryMinusY, $allCoordinateAry, $mode);
                }

                if($allCoordinateAry[$coordinateTurnToKeyIncreaseX]['safe_coordinate'] == -1 && $allCoordinateAry[$coordinateTurnToKeyIncreaseX]['mine'] == 0) {
                    $targetCoordinateAryIncreaseX = [
                        'target_coordinate_X' => $increaseCoordinateX,
                        'target_coordinate_Y' => $targetCoordinateAry['target_coordinate_Y']
                    ];
                    $allCoordinateAry = $this->checkoutSafeCoordinate($targetCoordinateAryIncreaseX, $allCoordinateAry, $mode);
                }

                if($allCoordinateAry[$coordinateTurnToKeyIncreaseY]['safe_coordinate'] == -1 && $allCoordinateAry[$coordinateTurnToKeyIncreaseY]['mine'] == 0) {
                    $targetCoordinateAryIncreaseY = [
                        'target_coordinate_X' => $targetCoordinateAry['target_coordinate_X'],
                        'target_coordinate_Y' => $increaseCoordinateY
                    ];
                    $allCoordinateAry = $this->checkoutSafeCoordinate($targetCoordinateAryIncreaseY, $allCoordinateAry, $mode);
                }
            }

                //The array of user's target coordinate and coordinates around.
                /*$upCoordinateTurnToKey =
                    ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $minusCoordinateY;
                $rightCoordinateTurnToKey =
                    ($mode['range'][1] - 1) * $minusCoordinateX + $minusCoordinateX + $targetCoordinateY;
                $leftCoordinateTurnToKey =
                    ($mode['range'][1] - 1) * $positionCoordinateX + $positionCoordinateX + $targetCoordinateY;
                $downCoordinateTurnToKey =
                    ($mode['range'][1] - 1) * $targetCoordinateX + $targetCoordinateX + $positionCoordinateY;

                $coordinateAroundTargetAry = [
                    0 => [
                        'coordinate_X' => $targetCoordinateX,
                        'coordinate_Y' => $targetCoordinateY
                    ],
                    1 => [
                        'coordinate_X' => $minusCoordinateX,
                        'coordinate_Y' => $minusCoordinateY
                    ],
                    2 => [
                        'coordinate_X' => $targetCoordinateX,
                        'coordinate_Y' => $minusCoordinateY
                    ],
                    3 => [
                        'coordinate_X' => $positionCoordinateX,
                        'coordinate_Y' => $minusCoordinateY
                    ],
                    4 => [
                        'coordinate_X' => $minusCoordinateX,
                        'coordinate_Y' => $targetCoordinateY
                    ],
                    5 => [
                        'coordinate_X' => $positionCoordinateX,
                        'coordinate_Y' => $targetCoordinateY
                    ],
                    6 => [
                        'coordinate_X' => $minusCoordinateX,
                        'coordinate_Y' => $positionCoordinateY
                    ],
                    7 => [
                        'coordinate_X' => $targetCoordinateX,
                        'coordinate_Y' => $positionCoordinateY
                    ],
                    8 => [
                        'coordinate_X' => $positionCoordinateX,
                        'coordinate_Y' => $positionCoordinateY
                    ]
                ];

                $coordinateAroundTargetAry = [
                    $allCoordinateAry[$upCoordinateTurnToKey],
                    $allCoordinateAry[$rightCoordinateTurnToKey],
                    $allCoordinateAry[$leftCoordinateTurnToKey],
                    $allCoordinateAry[$downCoordinateTurnToKey]
                ];

                foreach ($coordinateAroundTargetAry as $coordinateAroundTarget) {
                    $coordinateTurnToKey =
                        ($mode['range'][1] - 1) * $coordinateAroundTarget['coordinate_X'] + $coordinateAroundTarget['coordinate_X'] + $coordinateAroundTarget['coordinate_Y'];

                    $targetCoordinateAry['target_coordinate_X'] = $coordinateAroundTarget['coordinate_X'];
                    $targetCoordinateAry['target_coordinate_Y'] = $coordinateAroundTarget['coordinate_Y'];
                    $allCoordinateAry = $this->checkNumberOfMines($targetCoordinateAry, $allCoordinateAry, $mode);

                    if ($allCoordinateAry[$coordinateTurnToKey]['mine'] == 1) {
                        continue;
                    }

                    if ($allCoordinateAry[$coordinateTurnToKey]['safe_coordinate'] == 1) {
                        continue;
                    }

                    $allCoordinateAry[$coordinateTurnToKey]['safe_coordinate'] = 1;

                    //echo $allCoordinateAry[$coordinateTurnToKey]['mines_around'];
                    if ($allCoordinateAry[$coordinateTurnToKey]['mines_around'] == 0) {
                        return $this->checkoutSafeCoordinate($targetCoordinateAry, $allCoordinateAry, $mode);
                    }
                }*/
            return $allCoordinateAry;
        }

        /**
         * Return param to decide the game is over or not.
         *
         * @param array $targetCoordinateAry
         * @param array $allCoordinateAry
         * @param array $mode
         *
         * @return int
         */
        public function gameOver(array $targetCoordinateAry, array $allCoordinateAry, array $mode): int
        {
            $coordinateTurnToKey =
                ($mode['range'][1] - 1) * $targetCoordinateAry['target_coordinate_X'] + $targetCoordinateAry['target_coordinate_X'] + $targetCoordinateAry['target_coordinate_Y'];

            if($allCoordinateAry[$coordinateTurnToKey]['mine'] == 1) {
                echo "You Died"."\n";
                //$gameOver = 1;
                return 1;
            }

            //$gameOver = 0;
            return 0;
        }
    }


