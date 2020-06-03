<template>
  <v-card>
    <v-app-bar color="white" dense app>
      <v-app-bar-nav-icon @click="mini = !mini"></v-app-bar-nav-icon>

      <v-toolbar-title>Page title</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn text to="/login">
        <v-icon style="margin-right: 10px">mdi-login</v-icon>Login
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" :mini-variant.sync="mini" class="blue-grey darken-4" dark permanent app>
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-icon size="36">mdi-account-tie</v-icon>
        </v-list-item-avatar>

        <v-list-item-title>User Name</v-list-item-title>

        <v-btn icon @click.stop="mini = !mini">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item v-for="item in items" :key="item.title" link :to="item.link">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <div class="container-fluid" style="margin: 50px 0px 0 60px" :style="!mini ? 'margin-left: 260px' : 'margin-left: 60px'">
      <router-view></router-view>
    </div>
    <v-footer     
      color="white" 
      padless app
      border="top"
      colored-border
      elevation="4"
      >
      <v-col
        class="text-center"
        cols="12"
      >
        {{ new Date().getFullYear() }} — 
        <a href="https://uzautomotors.com/">
          <strong>UzAutoMotors </strong>
        </a>
        <span> Barcha huquqlar ximoyalangan.</span>
      </v-col>
    </v-footer>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      items: [
        { title: "My Account", icon: "mdi-account", link: "/"},
        { title: "Users", icon: "mdi-account-group-outline", link: "users"},
        { title: "Teleshkalar", icon: "mdi-account-group-outline", link: "teleshka-list"}
      ],
      mini: true
    };
  }
};
</script>