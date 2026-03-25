<?php

use App\Helpers\ViewHelper;
$page_title = $title ?? 'Dashboard admin';
$clients = $clients ?? [];

ViewHelper::loadHeader($page_title);
?>

<h1>BLEEEEH</h1>
<p>Clients (<?= hs((string) count($clients)); ?>)</p>

<?php if (empty($clients)): ?>
	<p>Aucun client.</p>
<?php else: ?>
	<ul>
		<?php foreach ($clients as $client): ?>
			<li>
				<strong><?= hs((string) ($client['prenom'] ?? '')); ?> <?= hs((string) ($client['nom'] ?? '')); ?></strong>
				- <?= hs((string) ($client['email'] ?? '')); ?>
				<?php if (!empty($client['telephone'])): ?>
					- <?= hs((string) $client['telephone']); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
