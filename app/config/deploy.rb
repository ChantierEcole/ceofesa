set :stages,        [ "preprod", "prod" ]
set :default_stage, "preprod"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set :application,   "ceofesa"
set :domain, "www.ceintranet.org"
ssh_options[:port] = "2224"
ssh_options[:forward_agent] = "2224"
set :keep_releases, 5

set :scm,         :git
set :scm_verbose, true
set :repository,  "git@github.com:ChantierEcole/ceofesa.git"

set :deploy_via, :remote_cache
set :deploy_to,  "/var/www/ceofesa/preprod"

set :use_sudo,         false
set :interactive_mode, false
set :user,             "ofesa"

set :writable_dirs,     ["app/cache", "app/logs"]

set :shared_files,    [ app_path + "/config/parameters.yml", web_path + "/.htaccess" ]
set :shared_children, [ log_path, web_path + "/uploads" ]

set :writable_dirs,       [ cache_path ]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

set :use_composer,               true
set :dump_assetic_assets,        true
set :normalize_asset_timestamps, false

role :web,        domain
role :app,        domain, :primary => true
role :db,         domain, :primary => true

before "symfony:assetic:dump", "symfony:assets:update_version"
after "deploy", "deploy:cleanup"
after "deploy", "symfony:clear_apc"
after "deploy:rollback:cleanup", "symfony:clear_apc"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL