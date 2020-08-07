


## Re:read
<p>「Re:read」は本の要約を投稿し、共有することができるサービスです。<br>
読書をする時、メモ帳などのアプリで要約をまとめていたのですが、
読み返すときに読みづらさを感じており、章、節などの区切りが
分かりやすいようにしたいと考えていました。<br>
また、他の人はどのように要約するのか、自分と比較することで
より一層学べることがあると考え、このアプリを作りました。<br>
ご活用していただけると幸いです。
</p>

##開発環境
- PHP 7.4.3
- Laravel 6.18.0
- Vue 2.6.11
- Docker(docker-compose)
    - php-fpm7.4-alpine3.11
    - nginx1.13.11-alpine
    - MySQL8.0.17
- GitHub

##インフラ
###AWS
- ECS(EC2タイプ)
- ECR
- ELB
- RDS(MySQL)
- S3
- CloudWatch
- CloudFront
- ACM
- Route53
- CodeBuild
- CodeDeploy
- CodePipeline
- CloudFormation
<br>

<span align="center">※開発時の都合上、インフラ関係のリポジトリを別にしています。</span>
<a href="https://github.com/heyar341/reread-deploy">https://github.com/heyar341/reread-deploy</a>
<p align="center"><img src="https://user-images.githubusercontent.com/53170504/89537986-fd6e8880-d834-11ea-822d-681b42d59321.png" width="400"></p>
<p align="center">インフラ構成図</p>
<br>

## 作成にあたり工夫した点
- アプリケーション
    - 投稿編集をしやすいように、TinyMCE(テキストエディター)を使用し、投稿編集をできるようにした。
    - 要約を投稿する書籍の情報を取得するためにGoogle Books APIを使用した。
    - ログイン中のユーザーとゲストユーザーのアクセス制限を行うためのミドルウェアを作成した。
    - ユーザーフォロー機能と投稿をお気に入りに追加する機能を実装した。
    - Bootstrapを使用し、レスポンシブ対応化した。
    - 各機能について、テストコードを作成した。

- Docker
    - alpineベースのイメージの使用とマルチステージビルドにより、イメージサイズの低減を行なった。
    
- インフラ
    - CloudFormationを使用し、インフラを構築した。
    - CloudFormationのファイルにパスワードなどの機密情報を入れないようにSSMを使用した。
    - ECSを使用し、開発環境と本番環境に差異が生じないようにした。
    - CodeBuild、CodePipeline、CodeDeployを使用し、CICD環境を構築した。
    - セキュリティーの観点から、環境設定ファイルをバージョン管理に含めず、CodeBuildでS3からコピーするようにした。
    - CloudFrontとRoute53を使用し、S3バケットのURLが分からないようにした。
    



