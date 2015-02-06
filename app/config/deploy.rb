set :stages,        %w(production develop)
set :default_stage, "develop"
set :stage_dir,     "app/config"

set :application, "FourxxiTestJobBundle"
set :app_path,    "app"

set :deploy_to,   "/var/www/test4xxi"
server 'www-data@dev', :app, :web, :primary => true

set :repository,  "git@git.megacoders.mooo.com:Sun/test4xxi.git"
set :scm,         :git
set :use_sudo,      false
set :shared_files,      ["app/config/parameters.yml"]

set :model_manager, "doctrine"

set  :keep_releases,  5