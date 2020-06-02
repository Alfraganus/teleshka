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
                autofocus
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
              <v-checkbox v-model="rememberMe" class="mx-2" label="Remember me" style="margin: 0"></v-checkbox>
              <v-btn color="rgb(32, 61, 91)" @click="login" class="col-12" dark>Login</v-btn>
            </v-form>
          </div>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      rememberMe: false,
      username: "",
      password: ""
    };
  },
  methods: {
    login() {
      this.$axios
        .post(this.$store.state.backend_url + "/api/users/login", {
          username: this.username,
          password: this.password
        })
        .then(res => {
          console.log(res);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
          alert("Login yoki parol xato!!!");
        });
    }
  },
  mounted() {
      this.$cookies.set('token', 'dsffgdsigjhsdkifgsdfg5sd4h6fsg5h4sd6f8hs4fg68hs8fs46dfh4df');
    console.log(this.$cookies.get('token'));
  }
};
</script>