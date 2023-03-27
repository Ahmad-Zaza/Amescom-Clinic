<?php

namespace App\Traits;

use App\Models\DoctorModels\Doctor;
use Illuminate\Support\Facades\Auth;

trait QueryTrait
{
    public function doPagination(array $params, $query)
    {
        // $query->orderBy($params['order_by'] ?? 'firstName', $params['order_sort'] ?? 'desc');


        $query->sortBy($params['order_by'] ?? 'id', 11, true);
        // $query->sortByDesc($params['order_by'] ?? 'id');
        // $query->values()->all();
        return $query->paginate($params['per_page'] ?? 10);
    }






    public function notification()
    {
        //$admin1 = Doctor::find($id);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        //$admin = Auth()->guard('admin-api')->user();
        $token = request()->bearerToken();

        // if($admin1 != $admin){
        //     return response()->json([
        //         'result' => null,
        //         'msg' => 'UnAuthenticate User!!'
        //     ]);
        // }

        if (!Auth::guard('patient-api')->check()) {
            return response()->json([
                'result' => null,
                'msg' => 'you are not authentication',
            ]);
        }


        $notification = [
            'title' => 'notification title',
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=Legacy server key',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        // return true;
        return response($notification);
    }
}