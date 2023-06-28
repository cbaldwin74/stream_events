# Stream Events

This repo contains a Laravel based web application that generates some metrics as well as a stream of recent events related to a streamer's online acitvity. 

The application is Laravel based with an integrated web front end. The web front end was scaffolded with Laravel Jetstream which uses Inertia as the glue between the UI and the API. Vue is used as the UI templating framework. In an Inertia application the API would include all the prop data which then be hydrated into the Vue component. For the purposes of this demo I opted not to follow this pattern and instead use Axios to call the API and fetch the data for the components. I belive that this better aligns with the spirit of the assignement, 

The one piece of required functionality that I did not complete was the infinite scroll for the events. The API call that is is using is setup to use cursor based pagination that should allow for the deisred behaviour. However the UI has not been implemented to take full advantage.

There is a public hosted version located [here](https://www.main-bvxea6i-aehzrucfiooys.ca-1.platformsh.site/login). Click the Twitch Glitch logo to login and get started.