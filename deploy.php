<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'local-deploy');

// Project repository
set('repository', 'https://github.com/deployphp/deployer.git');

// [Optional] Allocate tty for git clone. Default value is false.
// git clone 次第でtrue false に切り替える
set('git_tty', true); 

// Shared files/dirs between deploys 
// デプロイ時共有するdir, log, chache など
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
// web サーバが書き込み可能にする dir
set('writable_dirs', []);

// 環境を設定しない場合のデフォルトの STG
set('default_stage', 'develop');

// 現在の dir の位置を保存
set('current_dir', realpath(''));

// rollback 出来る世代数
// スペル間違えで反映されない
set('keep_releases', 3);

// // Hosts
// inventory('hosts.yml');

// # local に develop(開発ブランチ) をデプロイする
// # 環境は develop branch は 4.x デプロイ先は実行フォルダ内の dev
localhost('local-dev')
  ->stage('develop')
  ->set('branch', '4.x')
  ->set('deploy_path', get('current_dir').'/dev');

// # local に 本番(prod) をデプロイする
// # 環境は develop branch は 4.x デプロイ先は実行フォルダ内の dev
localhost('local-dev')
  ->stage('develop')
  ->set('branch', '4.x')
  ->set('deploy_path', get('current_dir').'/pro');

// Tasks

desc('Deploy your project to localhost');
task('deploy', [
    'deploy:info', // info
    'deploy:prepare', // server 接続、dir 作成
    'deploy:lock', // ?
    'deploy:release', // 整備
    'deploy:update_code', // git clone
    'deploy:shared', // 共有 dir
    'deploy:writable', // ?
    'deploy:vendors', // composer を使うとき
    'deploy:clear_paths', // ?
    'deploy:symlink', // symlink
    'deploy:unlock', // ?
    'cleanup', // 前回リリース ver を削除
    'success' // ?
]);

// [Optional] If deploy fails automatically unlock.
// deploy が失敗したとき unlock を呼び出す設定
after('deploy:failed', 'deploy:unlock');

// HelloWorld!! を実行
// ./dep hello
desc('HelloWorld!!');
task('hello', function() {
  // ↓ を表示
  writeln('HelloWorld!!');
});
