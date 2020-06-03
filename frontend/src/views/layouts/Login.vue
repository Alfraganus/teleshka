<template>
  <v-row class="logo-back fill-height justify-center">
    <v-col class="text-center" cols="5" style="max-width:440px;min-width:400px;margin-top:10%">
      <v-card :elevation="10">
        <v-col>
          <div class style="padding: 25px 10px 0 10px;">
            <img src="img/login_logo.png" alt width="190px" />
          </div>
          <div>
            <v-form @keyup.native.enter="login" style="padding: 15px">
              <v-text-field
                v-model="username"
                color="#203d5b"
                outlined
                dense
                label="Username"
                autocomplete="off"
              ></v-text-field>
              <v-text-field
                v-model="password"
                color="#203d5b"
                label="Enter your password"
                type="password"
                outlined
                dense
              ></v-text-field>
              <v-checkbox class="mx-2" label="Remember me" style="margin: 0"></v-checkbox>
              <v-btn color="rgb(32, 61, 91)" @click="login" class="col-12" dark>Login</v-btn>
            </v-form>
          </div>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
const axios = require("axios").default;
export default {
  data() {
    return {
      username: "test",
      password: "test",
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
          client_id: "7",
          client_secret: "op1mP1RlFCj6PMlgyzar9lvw7Yy1pE3OJbodBSL9",
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
