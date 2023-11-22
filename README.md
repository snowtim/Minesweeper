# Minesweeper
想法：  
以類似座標為構想  
類座標方便給予值來判斷是否有地雷或安全位置  
同時容易計算地雷與選擇位置距離，進而判斷有多少雷在附近八個格子內  

目前上傳有四個branch => master; version2; version3; version4 都是以上述為出發點來實作  
master =>  
最初始版本，選完座標判斷是否有雷，有雷則結束。  
若為安全座標則加入 $checkedCoordinateAry ，直到所有安全位置都在其中便成功結束遊戲。  
無法擴散求鄰近安全座標，很多地方很粗糙  

version2 =>  
以flood fill方式達成擴散  
同時純以二維陣列的值做為安全座標(value = 9)，地雷(value = -1)或周圍有雷(value = 周圍地雷數)  
但文字效果覺得比較不好標，搭前端似乎效果比較好  
先以邏輯能運作為主  

version3 =>  
先分出來看有什麼不同寫法可以改，尚無變動  

version4 =>  
同樣是以 flood fill 方式達成擴散  
Class MinesweeperService 中的 method -> checkoutSafeCoordinate() 中間大段註解掉是先自行試不以 flood fill 來實作  
最終雖能擴散，有缺陷且感覺沒 flood fill 好便棄用  
留下給自己看  
最主要完成品是這支，以文字方式顯示醜但可以全部跑出來  

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－  

檔案分三支(以 version4 為主)  
Minesweeper.php => 執行就跑這支就好。  

MinesweeperService.php => 踩地雷的各項邏輯。  
                          property: $allCoordinateAry 全部座標陣列；$targetCoordinateAry 指定踩下/選擇座標  
                          method:  
                          __construct() 現況沒用到其他物件，作用不大當練習做為自己的理解。  
                          其他主要分為   
                          generateAllCoordinatesBySelectMode() 產生所有座標；  
                          decideMinesCoordinate() 決定地雷所在座標；  
                          userSelectCoordinate() 使用者選擇座標；  
                          checkNumberOfMines() 檢查周圍地雷數(應該加上 Around.....之類的比較清楚)；  
                          checkoutSafeCoordinate() 踩到安全座標的擴散(以目前的判斷條件也是會有小瑕疵，能再加上剩下四個方位讓擴散完整但太醜就先以此版本做結束)；  
                          gameOver() 判斷遊戲是否結束。  
                          全部座標陣列未直接以座標當二維的 KEY(例:[1][1])之類方式去給原本想也許可以加點不同 KEY 去做定義並給值增加其他遊戲效果。  
                          像是踩到某塊可以幫忙消除三顆地雷；給予一次不死機會......  
                          做成[1][1]再給一些 KEY 去定義變三維覺得不好取用，寫起來變更醜就盡量讓它保持二維的模式。 
                          輸入重複座標結果會是一樣的就沒刻意去擋  
                          
MinesweeperConstant.php => 一些模式的值。現在有的很簡單，另開方便加。  

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－  

心得：  
自己覺得不好的地方  
1.似乎還有簡化的空間，感覺多餘或寫太長的地方不少  
2.變數及方法的命名不好。  

                          
                          
