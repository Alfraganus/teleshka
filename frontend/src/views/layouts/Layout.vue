<template>
  <v-card elevation="0">
    <v-app-bar color="white" dense app>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <!-- <v-toolbar-title>Bosh sahifa</v-toolbar-title> -->

      <v-spacer></v-spacer>

      <a href="/file/telejka.pptx">
        <v-btn depressed small color="primary">
          <v-icon left>mdi-arrow-down-circle-outline</v-icon>Qo'llanma
        </v-btn>
      </a>

      <v-btn text @click="Logout">
        <v-icon class="ml-2">mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant.sync="mini"
      class="blue-grey darken-4"
      expand-on-hover
      dark
      permanent
      app
      id="navbar"
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-icon size="36">mdi-account-tie</v-icon>
        </v-list-item-avatar>

        <v-list-item-title>{{ $user.fullname }}</v-list-item-title>

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
    <div
      class="container-fluid"
      style="margin: 50px 0px 55px 60px;"
      :style="!mini ? 'margin-left: 260px' : 'margin-left: 60px'"
    >
      <router-view></router-view>
    </div>
    <v-footer color="white" padless app border="top" colored-border elevation="4">
      <v-col class="text-center" cols="12">
        {{ new Date().getFullYear() }} —
        <a href="https://uzautomotors.com/">
          <strong>UzAutoMotors</strong>
        </a>
        <span>Barcha huquqlar ximoyalangan.</span>
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
        { title: "Bosh sahifa", icon: "mdi-home-outline", link: "/" },
        {
          title: "Foydalanuvchilar",
          icon: "mdi-account-group-outline",
          link: "users"
        },
        { title: "Joriy tamirlash", icon: "mdi-cog", link: "ppr" },
        {
          title: "Teleshkalar",
          icon: "mdi-truck-trailer",
          link: "teleshka-list"
        },
        {
          title: "Teleshka turlari",
          icon: "mdi-truck-trailer",
          link: "telly-type"
        },
        { title: "Bo'limlar", icon: "mdi-select-group", link: "department" },
        { title: "Smena", icon: "mdi-account-convert", link: "shift" }
      ],
      mini: true
    };
  },
  methods: {
    Logout() {
      this.$cookies.remove("token");
      this.$cookies.remove("users");
      this.$router.push("/login");
    }
  }
};
</script>