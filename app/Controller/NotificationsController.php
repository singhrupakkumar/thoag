<?php
App::uses('AppController', 'Controller');
class NotificationsController extends AppController {
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','RequestHandler','PushNotification','Session'); 
    
     public function beforeFilter() { 
        parent::beforeFilter();
        $this->Auth->allow(array('api_sendNotifications','SendPushNotificationsIos'));
    }

    
    
    public function api_sendNotifications() {
        $notification = $this->Notification->find('first',array('conditions'=>array('AND'=>array(
            'Notification.user_id'=>30,
            'Notification.notification_status'=>0
        )),
            'recursive'=>1
            )
                );
        $badge_count=1;
        $return_response = $this->PushNotification->SendPushNotificationsIos($notification['User']['device_token'],$notification['Notification']['id'],$badge_count);
        if($return_response){
            $response['isSuccess']=true;
            $response['msg']=$return_response;
        }else{
            $response['isSuccess']=false;
            $response['msg']='Some issue occured';
        }
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }
    
    /*
     * get notifications of a user
     */
    public function api_getNotification(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        //$redata='fdgfg';
        //$user_id=30;
        if(!empty($redata)){
            $notifications = $this->Notification->find('all',array('conditions'=>array('AND'=>array('Notification.user_id'=>$redata->user_id,'Notification.notification_status !='=>0)),'order'=>array('Notification.id DESC')));
            if($notifications){
                foreach ($notifications as $notification){
                    $modified_date = strtotime($notification['Notification']['modified']);
                    $notification['Notification']['modified_time']=date('d M,y h:i a',$modified_date);
                    $notification_list[]=$notification;
                }
                
                $response['isSuccess']=true;
                $response['data']=$notification_list;
            }else{
                $response['isSuccess']=false;
                $response['msg']='There is no notification';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']='Some issue occured';
        }
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }
    
    /*
     * 
     */
    public function SendPushNotificationsIos() {
        echo "cdgfgd";
        $device_token= 'fNTgcagA-VU:APA91bFlack2UzLUrQt6genNnNbAa9f7WDTY33LBVTkuAPDJjn-w0tOF7DG7OxkK-Wa0QayD4y_tv4W7HPCDfTA-FEsdWxsyL6W8WmpfX9qsBlPwNN_m2fzFDGciPQy8dr2QIL29vck2';
        $notification_id=1;
        $badge_count=1;
        $ch = curl_init();
        $notification_array = ClassRegistry::init('Notification')->find('first',array('conditions' => array('Notification.id' => $notification_id)));
          
          if(!empty($notification_array)){
            //Title of the Notification.
                  $title = $notification_array['Notification']['title'];
            //Body of the Notification.
                  $body = $notification_array['Notification']['message'];
                     $data = array('data' => $title.' notification');
              }
         
        //Creating the notification array.
        $notification = array('title' => $title, 'body' => $body, 'vibrate' => true, "click_action" => "FCM_PLUGIN_ACTIVITY", 'sound' => true, 'content-available' => '1', 'priority' => 'high','badge'=>$badge_count);
        
       //This array contains, the token and the notification. The 'to' attribute stores the token.
        $arrayToSend = array('to' => $device_token, 'notification' => $notification, 'data' => $data);

         //print_r($arrayToSend);exit;
        //Generating JSON encoded string form the above array.
        $json = json_encode($arrayToSend);

        //Setup headers:

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AIzaSyD9jmtIEdFxnFDsboHhDAzbs7wkGKEnWyA';

        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
        //Send the request
        $response = curl_exec($ch);

        //Close request
        curl_close($ch);
        //return $response;
        print_r($response);
        exit;
    }
    
}
?>