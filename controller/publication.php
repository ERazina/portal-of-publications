<?php
abstract class Controller_publication extends Controller_base {
    
    public static function start($method) {
			if (!$method) {
                self::view('addHeader');
				self::showPublications();
                self::view('addFooter');
			}
			else {
				self::$method();
			}
		}

    public static function add() {
            if (empty($_POST)) {
                self::view('addHeader');
                self::view('addAd');
                self::view('addArticle');
                self::view('addNews');
                self::view('addFooter');
            }
            else {
                if (Model_publication::getNewPublication($_POST)) {
                    header('Location: /' . BASE . 'publication');
                }
                else {
                    echo 'Возникла проблема при создании записи!';
                }
            }
        }

    public static function showPublications() {
        $publications = Model_publication::getList();
        // print_r($publications);
        self::view('publicationsList', array('publications' => $publications));
    }

    // public static function showPublications() {
    //     self::view('publicationsList');
    //     // Model_publication::getCurrentUser($_COOKIE);
    // }

 //     protected function __construct($post){
//         $this->heading = $post['heading'];
//         $this->text = $post['text'];
//         if($this instanceof News){
//             $this->source = $post['source'];
//         }
//         if($this instanceof Ad){
//             $this->expirationdate = $post['expirationdate'];
//         }
//         $this->save();
        
//     }
    // static function checkType($post){
    //     if(!empty($post['authors'])){
    //         return new Article($post);
    //     }
    //     if(!empty($post['expirationdate'])){
    //         return new Ad($post);
    //     }
    //     else{
    //         return new News($post);
    //     }
    // }
//     public function show(){}
//     public function mysort(){}
//     public function filter(){}
    
//     private function delete(){}
    
//     private function addMark(){}
    
//     abstract protected function save();
// }

// class News extends Publication {
//     protected $type = 'Новость';
//     protected $source;
//     protected function save(){
//         $db = mysqli_connect('localhost', 'root', '', 'publications');
//         mysqli_query($db, "
//             INSERT INTO `news` (`heading`, `text`, `source`)
//             VALUE ('{$this->heading}', '{$this->text}', '{$this->source}');
//         ");
//     }
// }
// class Ad extends Publication {
//     protected $type = 'Объявление';
//     protected $expirationdate;
//     protected function save(){
//         echo "Объявление";
//         $db = mysqli_connect('localhost', 'root', '', 'publications');
//         mysqli_query($db, "
//             INSERT INTO `ad` (`heading`, `text`, `expirationdate`)
//             VALUE ('{$this->heading}', '{$this->text}', '{$this->expirationdate}');
//         ");
//     }
// }
// class Article extends Publication {
//     protected $type = 'Статья';
//     protected $authors;
//     protected $mark;
//     protected function save(){
//         echo "Статья";
//         $db = mysqli_connect('localhost', 'root', '', 'publications');
//         mysqli_query($db, "
//             INSERT INTO `articles` (`heading`, `text`)
//             VALUE ('$heading', '$text');
//         ");
//     }         
}
?>
