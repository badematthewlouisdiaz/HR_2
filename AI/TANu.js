const express = require('express');
const multer = require('multer');
const cors = require('cors');
const fs = require('fs');
const pdfParse = require('pdf-parse');
const mammoth = require('mammoth');

const app = express();
const port = 5000;

app.use(cors());
app.use(express.json());

// Set up multer for file uploads
const upload = multer({ dest: 'uploads/' });

// Utility: Extract text from PDF
async function extractTextFromPDF(filePath) {
  const dataBuffer = fs.readFileSync(filePath);
  const data = await pdfParse(dataBuffer);
  return data.text;
}

// Utility: Extract text from DOC or DOCX
async function extractTextFromDOC(filePath) {
  const result = await mammoth.extractRawText({ path: filePath });
  return result.value;
}

// Example Question Generator Logic (Replace with TANU AI/NLP)
function generateQuestionsFromText(text) {
  // Simple logic: generate questions from headings and key sentences
  const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
  let questions = [];
  lines.forEach(line => {
    if (line.match(/^(.*:|#)/)) {
      // If line looks like a heading
      questions.push(`What is "${line.replace(/[#:]/g, '').trim()}"?`);
    } else if (line.length > 40) {
      // If it's a long sentence, make a generic question
      questions.push(`Summarize: "${line.slice(0, 30)}..."`);
    }
  });
  // Fallback if no questions
  if (questions.length === 0) {
    questions.push('No questions could be generated. Try a different module.');
  }
  return questions;
}

// Main API endpoint
app.post('/api/generate-questions', upload.single('file'), async (req, res) => {
  try {
    const file = req.file;
    if (!file) return res.status(400).json({ error: 'No file uploaded.' });

    let text = '';
    // Decide file type
    if (file.originalname.endsWith('.pdf')) {
      text = await extractTextFromPDF(file.path);
    } else if (
      file.originalname.endsWith('.doc') ||
      file.originalname.endsWith('.docx')
    ) {
      text = await extractTextFromDOC(file.path);
    } else {
      return res.status(400).json({ error: 'Unsupported file type.' });
    }

    // Generate questions
    const questions = generateQuestionsFromText(text);

    // Delete uploaded file after processing
    fs.unlinkSync(file.path);

    res.json({ questions });
  } catch (err) {
    console.error('Error:', err);
    res.status(500).json({ error: 'Server error.' });
  }
});

app.listen(port, () => {
  console.log(`TANU AI backend listening at http://localhost:{3306}`);
});