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
                placeholder="Login"
                type="text"
                outlined
                dense
                autocomplete="off"
              ></v-text-field>
              <v-text-field
                v-model="password"
                color="#203d5b"
                placeholder="Parol"
                type="password"
                outlined
                dense
                autocomplete="off"
              ></v-text-field>
              <v-checkbox class="mx-2" label="Remember me" style="margin: 0"></v-checkbox>
              <v-btn color="rgb(32, 61, 91)" @click="login" class="col-12" dark>
                Login
                <template v-slot:loader>
                  <span class="custom-loader">
                    <v-icon light dark>mdi-cached</v-icon>
                  </span>
                </template>
              </v-btn>
            </v-form>
          </div>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Swal from "sweetalert2";
const axios = require("axios").default;

export default {
  data() {
    return {
      username: "",
      password: "",
      loader: null
    };
  },
  methods: {
    login() {
      this.loader = !this.loader;
      axios
        .post(this.$store.state.backend_url + "/oauth/token", {
          grant_type: "password",
          // client_id: "7",
          // client_secret: "op1mP1RlFCj6PMlgyzar9lvw7Yy1pE3OJbodBSL9",
          client_id: "5",
          client_secret: "CZC1cQDoupNtr0J7oX8f4SAuSKZkzCn5BxZZo5aL",
          username: this.username,
          password: this.password
        })
        .then(res => {
          this.$cookies.set(
            "token",
            res.data.token_type + " " + res.data.access_token,
            "1h"
          );
          //this.$router.push("/"),
          axios.defaults.headers.common = {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: res.data.token_type + " " + res.data.access_token
          };
          axios
            .get(this.$store.state.backend_url + "/api/users/show")
            .then(ress => {
              this.$cookies.set("user", ress.data, "1h");
              //console.log(ress.data);
              location.replace("/");
            });
        })
        .catch(function(error) {
          Swal.fire({
            title: "Login yoki parol xato ..!",
            icon: "error",
            confirmButtonColor: "#d33"
          });
          console.error(error);
        });
    }
  }
};
</script>
