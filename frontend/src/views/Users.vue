<template>
    <div class="mx-4">
        <div class="px-10 py-4">
            <h1 class="title font-weight-medium">Foydalanuvchilar</h1>
        </div>
        <div>
             <v-subheader class="primary py-8 px-10" dark>
                    <v-row justify="center">
                        <v-dialog v-model="addUserModal" persistent max-width="450px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="success" dark v-on="on">Add User</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">Add user</span>
                            </v-card-title>
                            <v-card-text>
                            <v-container>
                                <v-row>
                                <v-col cols="12" >
                                    <v-text-field 
                                    v-model="fullName" 
                                    label="Fullname*" 
                                    required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                    v-model="userName"
                                    label="User name*"
                                    persistent-hint
                                    required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                    :items="['Admin', 'User']"
                                    label="Role*"                                    
                                    ></v-select>
                                </v-col>
                                </v-row>
                            </v-container>
                            </v-card-text>
                            <v-card-actions class="text-center">
                            <v-spacer></v-spacer>
                            <v-btn color="green" dark  @click="addUser">Add</v-btn>
                            <v-btn color="red darken-1" dark @click="addUserModal = false">Close</v-btn>
                            
                            </v-card-actions>
                        </v-card>
                        </v-dialog>
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
                    <td>{{ index +1 }}</td>
                    <td>{{ user.fullname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.role }}</td>
                    <td>                        
                        <v-btn class="mr-4" color="primary" outlined small dark>
                        <v-icon small>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn @click="deleteUser(user.id)" color="primary"  outlined small dark>
                        <v-icon color="red" text small>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
    </div>  
</template> 

<script>
export default {
  data() {
    return {
        users: [],
        fullName: '',
        userName: '',
        role: '',
        addUserModal: false,
    };
  },
  methods: {
      addUser(){
          this.$axios.post(this.$store.state.backend_url + '/api/users/create', {
            fullName: this.fullName,
            userName: this.userName,
            role: this.role
        })
        .then((response) => {
            this.addUserModal = false;
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
      },

      deleteUser(id){
          this.$axios.delete(this.$store.state.backend_url + '/api/users/delete/'+ id)
          .then((response) => {
              this.users = this.users.filter(v => v.id != id);
            alert(response.data + 'User Deleted');
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
      }
  },
  mounted(){
      this.$axios.get(this.$store.state.backend_url + '/api/users')
        .then((response) => {
            this.users = response.data;
            // console.log(this.users);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
  }
};
</script>