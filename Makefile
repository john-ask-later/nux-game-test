setup: ## Initial setup
	chmod a+x setup.sh
	./setup.sh

start: ## Run containers
	./vendor/bin/sail up -d

stop: ## Stop containers
	./vendor/bin/sail stop

drop: ## Drop everything
	./vendor/bin/sail down -v

rebuild: ## Rebuild everything from the scratch
	make drop
	make setup

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / \
  {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
