# developer-meets.com(仮)

動機    
→日本のITを救いたい  
どうせ日本のITは世界の先進国と比較して、非常に遅れを取っている(データはない)  
例えばアメリカの人口は日本の2.6倍だからエンジニアの数も 2.6 : 1 でなければならない
そして我々エンジニアがこの世に排泄(排出)するアプリ数も 2.6 : 1 もしくはそれ以上でなければいけない。   
  
日本の1年間の新規アプリリリース数(iOSに限定)は月間3000本程度らしい(データはないがアメリカとかはどうせもっとすごい)
つまり、どんどんアプリをリリースしちゃって、悪いものは淘汰されていいアプリだけが残るような構造をもっと作っていきたいってこと。

このサービスは日本全体の新規リリースを促進させるためだけに作成する




## ステージング環境
http://developer-meets.com/  
ステージング : xserverレンサバ  
nodebrewをインストール(xserverのレンサバはcurlが打てないっぽい)  
`wget git.io/nodebrew`  
セットアップ  
`perl nodebrew setup`  
パスを通す  
`echo 'export PATH=$HOME/.nodebrew/current/bin:$PATH' >> ~/.bashrc`  
`source ~/.bashrc`  
  
バージョン指定してnodeをインストール  
`nodebrew install-binary vx.x.x`  
  

利用可能バージョン確認  
`nodebrew ls`  
  
バージョンの切り替え  
`nodebrew use vx.x.x`  
`node -v`  
切り替わっていればOK  


### 開発環境
laravel6.0  
php7.3  
node v16.10.0  
npm 8.1.0  
  
  clone後は  
  `curl -sS https://getcomposer.org/installer | php`    
   `sudo mv composer.phar /usr/local/bin/composer`    
  `composer update`    
  `php artisan key:generate`    
  `php artisan migrate`    
  `npm install`    
  `npm run dev`    
   
  

