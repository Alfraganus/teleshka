<template>
  <v-row class="logo-back fill-height justify-center">
    <v-col class="align-self-center text-center" cols="4" style="max-width:420px;min-width:400px">
      <v-card :elevation="8">
        <div class="grey lighten-4" style="padding: 5px;">
          <div style="max-width: 170px;margin: 0 auto">
            <h1 class="display-2 font-italic font-weight-bold indigo--text darken-2--text">UzAuto</h1>
            <p
              class="font-weight-black indigo darken-2"
              style="letter-spacing: 10px;margin: 0 -4px 0 3px;padding: 0 0px 0 10px;color: #fff"
            >MOROTS</p>
          </div>
        </div>
        <div>
          <v-form ref="form" method="get" lazy-validation style="padding: 15px">
            <v-text-field
              v-model="name"
              name="login"
              :rules="nameRules"
              label="Login"
              outlined
              dense
              required
            ></v-text-field>
            <v-text-field
              name="password"
              label="Enter your password"
              :rules="passRules"
              type="password"
              outlined
              dense
            ></v-text-field>
            <v-btn color="success" type="submit" class="mr-4">Login</v-btn>
          </v-form>
        </div>
      </v-card>
    </v-col>
  </v-row>
</template>