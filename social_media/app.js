import React, { useState } from 'react';
import axios from 'axios';

function App() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [token, setToken] = useState('');

  const handleRegister = async () => {
    try {
      const response = await axios.post('http://localhost:3000/register', {
        username,
        password,
      });
      console.log(response.data);
    } catch (error) {
      console.error(error);
    }
  }
}