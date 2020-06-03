<template>
  <div id="app" style="margin-top: 7%">
    <v-app :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }" :dark="darkTheme" id="inspire">
      <v-container>
        <v-layout wrap>
          <v-flex cols12 md4 offset-md4>
            <v-card elevation="4" light tag="section">
              <v-container>
                <v-row>
                  <v-col cols="9" class="headline">{{ platformName }}</v-col>
                  <v-col cols="3">
                    <!--<v-img :alt="platformName" contain src="logo.jpg"></v-img>-->
                  </v-col>
                </v-row>
              </v-container>
              <v-divider></v-divider>
              <v-card-text>
                <p>Sign in with your username and password:</p>
                <v-form>
                  <v-row>
                    <v-col cols="12">
                      <label for="username">username</label>
                      <v-text-field
                        outlined
                        dense
                        hide-details="auto"
                        placeholer="username"
                        type="text"
                        autocomplete="off"
                        v-model="username"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <label for="username">password</label>
                      <v-text-field
                        outlined
                        dense
                        hide-details="auto"
                        type="password"
                        v-model="password"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
                <v-spacer></v-spacer>
                <v-btn color="info" @click="login">
                  <v-icon left>mdi-lock</v-icon>Login
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
          <v-flex sm12 md4 offset-md4>
            <v-layout align-center justify-space-between>
              <p class="caption my-3">
                Powered by
                <a href="#">UzAutoMotors</a>
              </p>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-container>
    </v-app>
  </div>
</template>

<script>
const axios = require("axios").default;
export default {
  data() {
    return {
      username: "",
      password: "",
      darkTheme: true,
      platformName: "UzAutoMotors Workflow",
      loading: false
    };
  },
  methods: {
    login() {
      axios
        .post(this.$store.state.backend_url + "/oauth/token", {
          grant_type: "password",
          client_id: "5",
          client_secret: "CZC1cQDoupNtr0J7oX8f4SAuSKZkzCn5BxZZo5aL",
          username: this.username,
          password: this.password
          // scope:
        })
        .then(res => {
          this.$cookies.set('token', res.data.token_type + " " + res.data.access_token);
            this.$router.push("/"),
          // this.$store.dispatch(
          //   "setAccessToken",
          //   res.data.token_type + " " + res.data.access_token,
          //   console.log(res)
          // );
          axios.defaults.headers.common = {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: res.data.token_type + " " + res.data.access_token
          };
        });
    }
  }
};
</script>
