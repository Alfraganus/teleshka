<template>
  <v-card>
    <v-app-bar color="deep-purple accent-4" dense dark app>
      <v-btn icon to="/">
        <v-icon size="32">mdi-home</v-icon>
      </v-btn>

      <v-toolbar-title>Page title</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn text to="/login">
        <v-icon style="margin-right: 10px">mdi-login</v-icon>Login
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" :mini-variant.sync="mini" class="grey darken-4" dark permanent app>
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
    <v-container style="margin: 50px 40px 0 60px" :style="!mini ? 'margin-left: 250px' : 'margin-left: 60px'">
      <router-view></router-view>
    </v-container>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      items: [
        { title: "My Account", icon: "mdi-account", link: "/"},
        { title: "Users", icon: "mdi-account-group-outline", link: "about"}
      ],
      mini: true
    };
  }
};
</script>