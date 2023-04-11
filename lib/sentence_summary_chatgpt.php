<?php

include('./conf/api_key.php');

class SentenceSummaryChatGPT {

    private $header = array();
    private $send_data = array();
    private $get_data = "";

    // ChatGPT APIエンドポイント
    private $endpoint = 'https://api.openai.com/v1/chat/completions';


    public function __construct() {
        $this->setHeader();
    }

    private function setHeader() {
        global $chatGPT_api_key;
        $this->header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $chatGPT_api_key,
        );
    }

    public function setSendData($text) {
        
        $prompt = <<<EOT2
 #命令書:
 あなたは高性能な要約マシンです。
 以下の制約条件と入力文をもとに、要約した日本語の文章を出力してください。
 
 #制約条件:
 ・文字数は500文字ほど
 ・重要なキーワードを取り残さない。
 ・文章を簡潔に。
 
 #入力文:
 {$text}
 
 #出力文:
EOT2;      
        
        $this->send_data = array(
            'model' => "gpt-3.5-turbo",
            'messages' => array(
                array(
                'role'=>'user',
                'content' => $prompt)
            )
        );
    }

    public function execSendData() {
        $context = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => implode("\r\n", $this->header),
                'content' => json_encode($this->send_data)
            )
        );
    
        $json = file_get_contents($this->endpoint, false, stream_context_create($context));
    
        // ここを外すとレスポンスを確認できる。
        var_dump($http_response_header);

        $this->get_data = $json;
    }

    public function formatJSONdata() {
        $tempHtml = '<ul>';
        $jsonArr = json_decode($this->get_data, true);
        if(empty($jsonArr)) {
            return false;
        }
        $tempHtml .= '<li>' . $jsonArr['choices'][0]['message']['content'] . '</li>';
                $tempHtml .= '</ul>';
        return $tempHtml;
    }
}