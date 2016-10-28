<?php
    class Model_publication {
    protected $heading, $text, $user_id, $table;
    
    protected function __construct($post){
        // $this->heading = $post['heading'];
        // $this->text = $post['text'];
        // $this->user_id = Model_user::getCurrentUser();

        // if($this instanceof news){
        //     $this->source = $post['source'];
        //     $this->table = 'news';
        // }
        // if($this instanceof ad){
        //     $this->expirationdate = $post['expirationdate'];
        //     $this->table = 'ads';
        // }
        // if($this instanceof article){
        //     $this->expirationdate = $post['expirationdate'];
        //     $this->table = 'articles';
        // }
        
        // $this->save();
        
    }

    public static function getNewPublication($post = array()) {
        if (!empty($post)) {
            $table = self::checkType(($post));
            $user_id = Model_user::getCurrentUser();
            $post['user_id'] = $user_id;
            return Controller_DB::insertPublication($table, $post);
        }
        else {
            return true;
        }
    }

    static function checkType($post){
        if(!empty($post['authors'])){
            $table = 'articles';
            return $table;
        }
        if(!empty($post['expirationdate'])){
            $table = 'ads';
            return $table;
        }
        if(!empty($post['source'])){
            $table = 'news';
            return $table;
        }
    }
    public static function getList() {
        // $cols = 
        // $tables = 
        // return Controller_DB::getObject('diary', $cols);
        return Controller_DB::getListItem();
    }

    public function mysort(){}
    public function filter(){}
    
    private function delete(){}
    
    private function addMark(){}
    
    
}

// class news extends Model_publication {
//     protected $type = 'Новость';
//     protected $source;

//     // protected function save(){
//     //     $db = mysqli_connect('localhost', 'root', '', 'publications');
//     //     mysqli_query($db, "
//     //         INSERT INTO `news` (`heading`, `text`, `source`)
//     //         VALUE ('{$this->heading}', '{$this->text}', '{$this->source}');
//     //     ");
//     // }
// }
// class ad extends Model_publication {
//     protected $type = 'Объявление';
//     protected $expirationdate;
//     // protected function save(){
//     //     echo "Объявление";
//     //     $db = mysqli_connect('localhost', 'root', '', 'publications');
//     //     mysqli_query($db, "
//     //         INSERT INTO `ad` (`heading`, `text`, `expirationdate`)
//     //         VALUE ('{$this->heading}', '{$this->text}', '{$this->expirationdate}');
//     //     ");
//     // }
// }
// class article extends Model_publication {
//     protected $type = 'Статья';
//     protected $authors;
//     protected $mark;
//     // protected function save(){
//     //     echo "Статья";
//     //     $db = mysqli_connect('localhost', 'root', '', 'publications');
//     //     mysqli_query($db, "
//     //         INSERT INTO `articles` (`heading`, `text`)
//     //         VALUE ('$heading', '$text');
//     //     ");
//     // }         
?>
