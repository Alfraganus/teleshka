<template>
  <div class="mx-4">
    <div class="px-10 py-4">
      <h1 class="title font-weight-medium">Foydalanuvchilar</h1>
    </div>
    <div>
      <v-subheader class="primary py-8 px-10" dark>
        <v-row justify="center">
          <v-btn color="success" @click="newUser()">New item</v-btn>
        </v-row>
      </v-subheader>
    </div>
    <v-simple-table fixed-header height="auto">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left font-weight-bold">ID</th>
            <th class="text-left font-weight-bold">Fullname</th>
            <th class="text-left font-weight-bold">Email</th>
            <th class="text-left font-weight-bold">Username</th>
            <th class="text-left font-weight-bold">Role</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ user.fullname }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.username }}</td>
            <td>{{ roles.find( v => v.value == user.role) ? roles.find( v => v.value == user.role).text : '' }}</td>
            <td>
              <v-btn class="mr-4" color="primary" @click="editUser(user)" outlined small dark>
                <v-icon small>mdi-pencil</v-icon>
              </v-btn>

              <v-btn @click="deleteUser(user.id)" color="primary" outlined small dark>
                <v-icon color="red" text small>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <v-dialog v-model="saveUserModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">Add user</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field v-model="form.fullname" label="Fullname*" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="form.username" label="User name*" persistent-hint required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select v-model="form.role" label="Role*" :items="roles"></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="text-center">
          <v-spacer></v-spacer>
          <v-btn color="green" dark @click="saveUser">Add</v-btn>
          <v-btn color="red darken-1" dark @click="saveUserModal = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template> 

<script>
export default {
  data() {
    return {
      users: [],
      fullName: "",
      userName: "",
      saveUserModal: false,
      form: {},
      roles: [
        {
          text: "User",
          value: "0"
        },
        {
          text: "Admin",
          value: "1"
        },
        {
          text: "Administrator",
          value: "2"
        }
      ]
    };
  },
  methods: {
    newUser() {
      this.saveUserModal = true;
      this.form = {
        fullname: "",
        username: "",
        role: ""
      };
    },
    editUser(item) {
      this.saveUserModal = true;
      this.form =  JSON.parse(JSON.stringify(item));
    },
    saveUser() {
      if (!this.form.id)
        this.$axios
          .post(this.$store.state.backend_url + "/api/users/create", this.form)
          .then(response => {
            this.saveUserModal = false;
            this.users.push(response.data);
          })
          .catch(function(error) {
            console.log(error);
          });
      else
        this.$axios
          .post(this.$store.state.backend_url + "/api/users/update/"+this.form.id, this.form)
          .then(response => {
            this.saveUserModal = false;
            this.users = this.users.map(v => {
              if (v.id == response.data.id) v = response.data;
              return v;
            });
          })
          .catch(function(error) {
            console.log(error);
          });
    },
    deleteUser(id) {
      this.$axios
        .delete(this.$store.state.backend_url + "/api/users/delete/" + id)
        .then(response => {
          this.users = this.users.filter(v => v.id != id);
          alert(response.data + "User Deleted");
        })
        .catch(function(error) {
          console.error(error);
        });
    },
    getList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/users")
        .then(response => {
          this.users = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getList();
  }
};
</script>