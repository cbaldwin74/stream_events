# Stream Events

This repo contains a Laravel based web application that generates some metrics as well as a stream of recent events related to a streamer's online activity. 

The application is Laravel based with an integrated web front end. The web front end was scaffolded with Laravel Jetstream which uses Inertia as the glue between the UI and the API. Vue is used as the UI templating framework. In an Inertia application the API would include all the prop data which then be hydrated into the Vue component. For the purposes of this demo I opted not to follow this pattern and instead use Axios to call the API and fetch the data for the components. I belive that this better aligns with the spirit of the assignment, 

There is a public hosted version located [here](https://www.main-bvxea6i-aehzrucfiooys.ca-1.platformsh.site/login). Click the Twitch Glitch logo to login and get started.

## Todos
* Update the event list API endpoint to accept a pagination cursor so it can return the next page of items
* Update the UI to so that the list displays different messages for each of the event types  
  This would be accomplished by creating a Vue component for each message type and display these in the table instead of the raw data
* Implement infinite scrolling in the UI using the cursor with the API call
* Implement the UI and API for marking the messages as read.
