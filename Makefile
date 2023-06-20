init: api.init app.init
restart: api.restart app.restart

# API related commands
api.init:
	$(MAKE) -C ./api init

api.restart:
	$(MAKE) -C ./api down up

api.sync-fruits:
	$(MAKE) -C ./api sync-fruits

api.migrate:
	$(MAKE) -C ./api migrate

api.logs:
	$(MAKE) -C ./api logs

# APP related commands
app.init:
	$(MAKE) -C ./app init

app.restart:
	$(MAKE) -C ./app down up
