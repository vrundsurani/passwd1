<?php
require 'db.php';

$apps = $pdo->query("SELECT * FROM apps")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Roll Rusher App Store</title>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen flex flex-col">

<header class="py-8 bg-gradient-to-r from-purple-900 via-indigo-900 to-purple-900 text-center shadow-lg">
  <h1 class="text-4xl font-bold tracking-wide">FF Max Panel</h1>
  <p class="mt-2 text-lg">Premium FF Max Panel by Roll Rusher. Telegram [ @roll_rusher_bot ]</p>
</header>

<div class="flex flex-wrap justify-center p-8 gap-6 max-w-7xl mx-auto flex-1">
  <?php foreach ($apps as $app): ?>
    <div class="h-80 bg-gradient-to-br from-purple-600 via-purple-500 to-indigo-600 hover:scale-105 transform transition-all duration-300 rounded-xl p-6 w-full max-w-xs shadow-lg cursor-pointer">
      <div class="flex justify-center mb-4">
        <div class="bg-white p-3 rounded-full shadow-lg overflow-hidden w-20 h-20 flex items-center justify-center">
          <img src="<?php echo $app['icon']; ?>" alt="<?php echo htmlspecialchars($app['name']); ?>" class="max-w-full max-h-full object-contain rounded-full" />
        </div>
      </div>
      <h3 class="text-xl font-semibold mb-2 text-center truncate"><?php echo htmlspecialchars($app['name']); ?></h3>
      <p class="text-sm mb-4 text-center truncate"><?php echo htmlspecialchars($app['description']); ?></p>
      <a href="download.php?file=<?php echo urlencode($app['file']); ?>"
         class="block bg-white text-indigo-600 px-4 py-2 rounded-full font-semibold text-center hover:bg-gray-100 transition">Download</a>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>
