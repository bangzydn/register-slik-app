?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Reader</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #f8f9fa;
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .form-section { 
            margin-bottom: 30px; 
            padding-bottom: 30px; 
            border-bottom: 2px solid #e9ecef; 
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #495057; }
        input[type="text"] { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #007bff; 
            border-radius: 8px;
            background-color: #fff;
            font-size: 16px;
        }
        input[type="file"] { 
            width: 100%; 
            padding: 12px; 
            border: 2px dashed #007bff; 
            border-radius: 8px;
            background-color: #f8f9ff;
        }
        button { 
            background: #007bff; 
            color: white; 
            padding: 12px 30px; 
            border: none; 
            border-radius: 5px;
            cursor: pointer; 
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover { background: #0056b3; }
        .error { 
            color: #dc3545; 
            background: #f8d7da; 
            padding: 10px; 
            border-radius: 5px; 
            margin: 10px 0; 
        }
        .success { 
            color: #155724; 
            background: #d4edda; 
            padding: 10px; 
            border-radius: 5px; 
            margin: 10px 0; 
        }
        .upload-area { 
            border: 2px dashed #007bff; 
            padding: 30px; 
            text-align: center; 
            border-radius: 10px;
            background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
        }
        .results-section { margin-top: 30px; }
        .metadata { 
            background: #f8f9fa; 
            padding: 20px; 
            margin-bottom: 20px; 
            border-radius: 8px; 
            border-left: 4px solid #007bff;
        }
        .content { 
            background: white; 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            max-height: 500px;
            overflow-y: auto;
        }
        .page-content { 
            margin-bottom: 30px; 
            padding: 20px; 
            border-left: 4px solid #007bff; 
            background: #f8f9ff;
            border-radius: 0 8px 8px 0;
        }
        pre { 
            white-space: pre-wrap; 
            word-wrap: break-word; 
            font-family: 'Courier New', monospace;
            line-height: 1.4;
        }
        .tabs { 
            margin-bottom: 20px; 
            border-bottom: 2px solid #e9ecef;
        }
        .tab-btn { 
            background: #e9ecef; 
            border: none; 
            padding: 12px 24px; 
            cursor: pointer; 
            margin-right: 5px; 
            border-radius: 8px 8px 0 0;
            font-weight: 500;
            transition: all 0.3s;
        }
        .tab-btn.active { 
            background: #007bff; 
            color: white; 
        }
        .tab-btn:hover:not(.active) { 
            background: #dee2e6; 
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .file-info {
            background: #e3f2fd;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: 500;
        }
        .clear-btn {
            background: #6c757d;
            margin-left: 10px;
        }
        .clear-btn:hover {
            background: #545b62;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PDF File Reader</h1>
        
        <!-- Upload Form Section -->
        <div class="form-section">
            @if ($errors->any())
                <div class="error">
                    <strong>Error:</strong>
                    <ul style="margin: 5px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($fileName)
                <div class="success">
                    <strong>✓ Successfully processed:</strong> {{ $fileName }}
                    @if($userName)
                        <br><strong>👤 Processed by:</strong> {{ $userName }}
                    @endif
                </div>
            @endif

            <form action="{{ route('pdf-reader.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="upload-area">
                    <div class="form-group">
                        <label for="user_name">👤 Your Name:</label>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $userName) }}" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="pdf_file">📄 Select PDF File to Read:</label>
                        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required>
                    </div>
                    
                    <button type="submit">🔍 Read PDF Content</button>
                    @if($text)
                        <button type="button" class="clear-btn" onclick="clearResults()">🗑️ Clear Results</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Results Section -->
        @if($text)
        <div class="results-section">
            <h2>📊 PDF Analysis Results</h2>
            
            <!-- PDF Metadata -->
            <div class="metadata">
                <h3>📋 Document Information</h3>
                @if($userName)
                    <div class="file-info">👤 Processed by: {{ $userName }}</div>
                @endif
                <div class="file-info">📁 File: {{ $fileName }}</div>
                <p><strong>📄 Number of Pages:</strong> {{ $pageCount }}</p>
                @if(isset($details['Title']) && $details['Title'])
                    <p><strong>📝 Title:</strong> {{ $details['Title'] }}</p>
                @endif
                @if(isset($details['Author']) && $details['Author'])
                    <p><strong>👤 Author:</strong> {{ $details['Author'] }}</p>
                @endif
                @if(isset($details['Creator']) && $details['Creator'])
                    <p><strong>🛠️ Creator:</strong> {{ $details['Creator'] }}</p>
                @endif
                @if(isset($details['CreationDate']) && $details['CreationDate'])
                    <p><strong>📅 Creation Date:</strong> {{ $details['CreationDate'] }}</p>
                @endif
            </div>

            <!-- Content Tabs -->
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('full-content')">📄 Full Content</button>
                <button class="tab-btn" onclick="showTab('page-by-page')">📑 Page by Page</button>
            </div>

            <!-- Full Content Tab -->
            <div id="full-content" class="tab-content active">
                <div class="content">
                    <h3>📖 Complete PDF Text Content</h3>
                    <pre>{{ $text ?: 'No text content found in this PDF.' }}</pre>
                </div>
            </div>

            <!-- Page by Page Tab -->
            <div id="page-by-page" class="tab-content">
                <h3>📑 Content by Page</h3>
                @if($pageTexts && count($pageTexts) > 0)
                    @foreach($pageTexts as $pageNum => $pageText)
                        <div class="page-content">
                            <h4>📄 Page {{ $pageNum }}</h4>
                            <pre>{{ $pageText ?: 'No text content found on this page.' }}</pre>
                        </div>
                    @endforeach
                @else
                    <div class="page-content">
                        <p>No page content available.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <script>
        // Tab functionality
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab and activate button
            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // File input interactivity
        document.getElementById('pdf_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                console.log('Selected file:', fileName);
                // You could add a preview of the selected file name here
            }
        });

        // Clear results function
        function clearResults() {
            if (confirm('Are you sure you want to clear the results and upload a new file?')) {
                window.location.href = '{{ route("pdf-reader.index") }}';
            }
        }

        // Smooth scroll to results when they appear
        @if($text)
        document.addEventListener('DOMContentLoaded', function() {
            const resultsSection = document.querySelector('.results-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
        @endif
    </script>
</body>
</html>

<?php