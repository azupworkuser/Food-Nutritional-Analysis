# Food Nutritional Analysis

## Used Technologies

- `Backend`: Symfony 6
- `Frontend`: Vue.js
- `Environment`: Docker

## Container details:

1. `NUTRITIONS_PHP` for the Backend.
2. `NUTRITIONS_APP` for the Frontend.
3. `NUTRITIONS_DB` for Mysql Database.
4. `NUTRITIONS_API` for nginx server.
5. `NUTRITIONS_MAILHOG` for mailhog server.

## Local setup

```sh
# For building the containers and migrating the database
make init
```

```sh
# For Running the console command to fetch the fruits data from third-party.
make api.sync-fruits

# Or you can run this manually using the below command:
docker exec -it docker exec -it NUTRITIONS_PHP php bin/console app:fruits-fetch
```

> Now the project should be up and running on http://localhost:8080
> NOTE: You can check the mail (mailhog) on http://localhost:8082

# API calls
Now if we talk about the API calls, I have 4 API calls:

1. `/fruit/families`: For getting the list of fruit families.
2. `/fruits`: For getting the list of fruits based on the filter query and pagination.
3. `/fruits/{uuid}/toggle-favorite`: For marking the fruit as favorite or un-favorite. 
4. `/fruits/favorites`: For getting the list of favorite fruits.

You can see the [nutritions-finder.http](./api/nutritions-finder.http) file for getting more details about the API calls.

# Glance at the UI

![Image](https://i.imgur.com/WtKEDwc.png?q=1)
![Image](https://i.imgur.com/ofAFNtE.png?q=2)
![Image](https://i.imgur.com/THzzkSv.png?q=3)
