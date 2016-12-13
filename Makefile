UNAME := $(shell uname -s)
COMPOSE=docker-compose
RUN=$(COMPOSE) run --rm tools
COMPOSER=composer
SYMFONY=app/console
DOCKER=docker

all: configure start install

configure:
	@touch docker/var/.bash_history
	@echo "WWW_DATA_UID=`id -u`\nWWW_DATA_GUID=`id -g`\nLOCAL_IP=`ip route get 1 | awk '{print $$NF;exit}'`" | tee docker/settings/env_access > /dev/null

start:
	$(DOCKER) restart docker-hostmanager || true
	$(COMPOSE) up -d

stop:
	$(COMPOSE) kill

install:
	$(RUN) $(COMPOSER) install --no-interaction --prefer-dist || true

dev:
	$(RUN) $(SYMFONY) do:mi:mi -n
	$(RUN) $(COMPOSER) install --no-interaction --prefer-dist
	$(RUN) $(SYMFONY) ass:dump

clean:
	$(RUN) $(SYMFONY) do:da:dr --force || true

build:
	$(RUN) $(SYMFONY) do:da:cr || true

redev: clean build dev
