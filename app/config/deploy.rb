set :stages,        [ "preprod", "prod" ]
set :default_stage, "preprod"
set :stage_dir,     "app/config"

set :application,   "ceofesa"
set :domain, "151.80.58.64"
set :keep_releases, 5

set :scm,         :git
set :scm_verbose, true
set :repository,  "git@github.com:ChantierEcole/ceofesa.git"

set :deploy_via, :remote_cache

set :use_sudo,         false
set :interactive_mode, false
set :user,             "admin"

set :writable_dirs,     ["app/cache", "app/logs"]

set :shared_files,    [ app_path + "/config/parameters.yml", web_path + "/.htaccess"]
set :shared_children, [ log_path, web_path + "/uploads" ]

set :writable_dirs,       [ cache_path ]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true
ssh_options[:forward_agent] = true

set :use_composer,               true
set :dump_assetic_assets,        true
set :normalize_asset_timestamps, false

role :web,        domain
role :app,        domain, :primary => true
role :db,         domain, :primary => true

before "symfony:assetic:dump", "symfony:assets:update_version"
after "deploy", "deploy:cleanup"
after "deploy", "restart_fpm"
after "deploy", "symfony:doctrine:migrations:migrate"
after "deploy:rollback:cleanup", "restart_fpm"

task :restart_fpm do
  servers = find_servers_for_task(current_task)
  servers.each do |server|
    capifony_pretty_print "--> Restarting FPM"
    run "sudo service php5-fpm restart", :hosts => server
    capifony_puts_ok
  end
end

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
