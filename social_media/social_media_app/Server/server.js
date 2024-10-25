// server.js
const express = require('express');
const mongoose = require('mongoose');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

const app = express();

mongoose.connect('mongodb://localhost/social_media_app', { useNewUrlParser: true, useUnifiedTopology: true });

const userSchema = new mongoose.Schema({
  username: String,
  password: String,
  heartRateData: [{ type: mongoose.Schema.Types.ObjectId, ref: 'HeartRateData' }]
});

const User = mongoose.model('User', userSchema);

app.use(express.json());

// Registration endpoint
app.post('/register', async (req, res) => {
  const { username, password } = req.body;
  const hashedPassword = await bcrypt.hash(password, 10);
  const user = new User({ username, password: hashedPassword });
  await user.save();
  res.json({ message: 'User created successfully' });
});

// Login endpoint
app.post('/login', async (req, res) => {
  const { username, password } = req.body;
  const user = await User.findOne({ username });
  if (!user) {
    return res.status(401).json({ message: 'Invalid username or password' });
  }
  const isValidPassword = await bcrypt.compare(password, user.password);
  if (!isValidPassword) {
    return res.status(401).json({ message: 'Invalid username or password' });
  }
  const token = jwt.sign({ userId: user._id }, process.env.SECRET_KEY, { expiresIn: '1h' });
  res.json({ token });
});

// Protected endpoint
app.get('/protected', async (req, res) => {
  const token = req.header('Authorization').replace('Bearer ', '');
  const decodedToken = jwt.verify(token, process.env.SECRET_KEY);
  const user = await User.findById(decodedToken.userId);
  if (!user) {
    return res.status(401).json({ message: 'Invalid token' });
  }
  res.json({ message: 'Welcome to the protected route!' });
});

app.listen(3000, () => {
  console.log('Server started on port 3000');
});