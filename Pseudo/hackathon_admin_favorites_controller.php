<?php
class hackathon_admin_favorites_controller {
    private $user_id;
    
    private function get_session_user_id() {
        $this->user_id = $session_userid;    
    }
    
    public function ajax_get_favs() {
        $limit = $getMagSysConfig('hackathon_admin_favorites/general/limit');
        /*
           favs:  select url, label from admin_favorites where user_id = $this->user_id and is_favorite = 1 limit $limit
           recent:select url, label from admin_favorites where user_id = $this->user_id order by updated_at DESC limit $limit
           popular:  select url, label from admin_favorites where user_id = $this->user_id order by visits DESC limit $limit
        */
    }
    
    public function ajax_toggle_fav() {
        /*
            update admin_favorites set 
                updated_at = now,
                is_favorite = 1 - is_favorite
                 where user_id = $this->user_id 
        */    
    }
    
    public function ajax_edit_label($new_label) {
    /*
        update admin_favorites set 
                label = $new_label
                where user_id = $this->user_id
    */            
    }   
}