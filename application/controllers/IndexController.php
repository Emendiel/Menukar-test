<?php

class IndexController extends Zend_Controller_Action
{
    protected $db;

    public function init()
    {
        /* Initialize action controller here */
        $this->db = Zend_Db::factory('Pdo_Mysql', array(
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'gfqa4av3',
        'dbname'   => 'Menukar-test'
        ));
    }

    public function indexAction()
    {
        $this->view->db = $this->db;
        $cat = $this->getRequest()->getParam('cat', null);
        $article = $this->getRequest()->getParam('article', null);
        
        $cat = (is_numeric($cat)) ? $cat : 0;
        $this->view->cat = $cat;
        
        $this->view->request = 0;
        
        $article = (is_numeric($article)) ? $article : 0;
        $this->view->article = $article;
        
        if(empty($cat) || $cat == "home") {
          $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE Ligne_N=0 ORDER BY `news`.`ID_N` DESC LIMIT 5", 2);
          return true;
        } else if(empty($article)){
          $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE Ligne_N=0 AND Cat_N=".$cat." ORDER BY `news`.`ID_N` DESC LIMIT 5", 2);
          return true;
        } else {
          $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE Ligne_N=0 AND Cat_N=".$cat." AND ID_N=".$article." ORDER BY `news`.`ID_N` DESC LIMIT 5", 2);
          return true;
        }
        
        $this->view->error = "No category has send !";
        return false;
    }
    
    public function searchAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->db = $this->db;
        $search = $this->getRequest()->getParam('search', null);
        $type = $this->getRequest()->getParam('type', null);
        
        if($search) {
          if($type && $type == "tag") {
            $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE Tag_N like '%".$search."%' ORDER BY `news`.`ID_N` DESC", 2);
            return true;
          } else if($type && $type == "alone") {
            $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE ID_N=".$search, 2);
            return true;
          } else if(strlen($search) > 2){
            $this->view->request = $this->db->fetchAll("SELECT * FROM news WHERE Text_N like '%".$search."%' OR Tag_N like '%".$search."%' OR Nom_N like '%".$search."%' OR Auteur_N like '%".$search."%' ORDER BY `news`.`ID_N` DESC", 2);
            return true;
          } else {
            echo "Your research is too short. Please write words with more 3 characters. Thank you for your understanding";
            return false;
          }
        } else {
          echo "Your research is too short. Please write words with more 3 characters. Thank you for your understanding";
          return false;
        }
    }
    
    public function commentaireAction()
    {
      $this->_helper->layout->disableLayout();
      $this->view->db = $this->db;
      $news = $this->getRequest()->getParam('news', null);
      
      if($news) {
        $this->view->request = $this->db->fetchAll("SELECT * FROM commentaires WHERE ID_N='".$news."' ORDER BY `commentaires`.`ID_C` DESC", 2);
        return true;
      } else {
        return false;
      }
    }
    
    public function addcommentaireAction()
    {
      $this->_helper->layout->disableLayout();
      $this->getRequest()->setParam('format', 'json');
      $contextSwitch = $this->_helper->getHelper('contextSwitch');
      $contextSwitch->addActionContext($this->getRequest()->getActionName(), array('json'));
      $contextSwitch->initContext();
      
      $success = false;
      
      $pseudo = $this->getRequest()->getParam('pseudo', null);
      $email = $this->getRequest()->getParam('email', null);
      $comment = $this->getRequest()->getParam('comment', null);
      $id = $this->getRequest()->getParam('id', null);
      
      $t1 = preg_match("#^[éèàôöäâùêûa-zA-Z0-9._-]{2,150}$#i", $pseudo);
      $t2 = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $email);
      $t3 = preg_match("#^[0-9]+$#i", $id);
      
      $comment = htmlspecialchars($comment);
      
      if($t1 && $t2 && $t3) {
        $date_com = date('d/m/Y');
        $heure_com = date('H\hi');
        
        $this->db->query("INSERT INTO `commentaires` (`ID_C` ,`ID_N` ,`Auteur_C` ,`Text_C` ,`Date_C` ,`Heure_C`)
          VALUES (NULL , '".$id."', '".$pseudo."', '".$comment."', '".$date_com."', '".$heure_com."');", 2);
          
        $success = true;
      }
      
      $this->view->success = $success;
    }
}

