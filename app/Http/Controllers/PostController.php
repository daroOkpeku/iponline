<?php

namespace App\Http\Controllers;

use App\Http\Requests\valid;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function chatgpt(valid $request){
            // // Set your OpenAI API key
            $api_key = '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';

            // Set the API endpoint URL
            $endpoint = 'https://api.openai.com/v1/completions';

            // Set the prompt for generating completions


            $densityRange = explode("-", $request->destiny); // Keyword density range
            $tone = $request->tone;
            $prompt = "{$request->prompt}\n\n{$densityRange[0]}% and {$densityRange[1]}% and write in a {$tone} tone.";

            // Set the headers for the cURL request
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ];


            $data = [
                'model' => "gpt-3.5-turbo-instruct",
                'prompt' => $prompt,
                'temperature' => 0.7,
                'max_tokens' => 150,
            ];

            // Set the data payload for the cURL request

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL session
            $response = curl_exec($ch);
           $imgone = $this->imageai($request->prompt);
          $imgtwo =  $this->imagealtwo($request->prompt);
            return response()->json(["success"=>$response, 'imgone'=> $imgone, 'imgtwo'=>$imgtwo]);
            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }


}

// https://api.openai.com/v1/images/generations


                public function imageai($prompt){

                    $curl = curl_init();

                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://api.getimg.ai/v1/stable-diffusion/text-to-image",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => json_encode([
                        'scheduler' => 'euler',
                        'output_format' => 'png',
                        'prompt' => $prompt
                      ]),
                      CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "authorization: Bearer key-2FcJdnmetG9Q2P6uP75WJmAZp7PfBw4qfPohJ43wyA20tpFMExeYThOtjnZvzZoxRebs7GgwowtO32WjW78q6gfb5vbdbusg",
                        "content-type: application/json"
                      ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);
                    return $response;
                    // if ($err) {
                    //   echo "cURL Error #:" . $err;
                    // } else {
                    //   echo $response;
                    // }

                }



            public function imagealtwo($prompt){
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://modelslab.com/api/v3/text2img',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "key": "82sb0FPm6QmQVw7gxsXdGfKOCGYUjhOCzhbqSvI9F5PdEravvIEX0jNamJAt",
                    "prompt": "'.$prompt.'",
                    "negative_prompt": "((out of frame)), ((extra fingers)), mutated hands, ((poorly drawn hands)), ((poorly drawn face)), (((mutation))), (((deformed))), (((tiling))), ((naked)), ((tile)), ((fleshpile)), ((ugly)), (((abstract))), blurry, ((bad anatomy)), ((bad proportions)), ((extra limbs)), cloned face, (((skinny))), glitchy, ((extra breasts)), ((double torso)), ((extra arms)), ((extra hands)), ((mangled fingers)), ((missing breasts)), (missing lips), ((ugly face)), ((fat)), ((extra legs))",
                    "width": "512",
                    "height": "512",
                    "samples": "1",
                    "num_inference_steps": "20",
                    "safety_checker": "no",
                    "enhance_prompt": "yes",
                    "temp": "yes",
                    "seed": null,
                    "guidance_scale": 7.5,
                    "webhook": null,
                    "track_id": null
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                return $response;

            }

}
