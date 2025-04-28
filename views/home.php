<h1>{{ headline }}</h1>
<ul>
<?php foreach($vars['users'] as $u): ?>
    <li>
            <ul><?= htmlspecialchars($u->getUsername()) ?></ul>
            <ul><?= htmlspecialchars($u->getEmail()) ?></ul>
    </li>
<?php endforeach; ?>
</ul>
