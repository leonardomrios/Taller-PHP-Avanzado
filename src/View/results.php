<?php /** @var string $title */ ?>
<h4 class="mb-3"><?= htmlspecialchars($title ?? 'Resultados') ?></h4>
<?php if (!empty($sections)): ?>
  <?php foreach ($sections as [$secTitle, $data]): ?>
    <div class="mb-4">
      <h6 class="fw-bold"><?= htmlspecialchars($secTitle) ?></h6>
      <?php if (is_array($data)): ?>
        <pre class="bg-light p-3 border rounded small"><?php echo htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); ?></pre>
      <?php else: ?>
        <div class="p-3 bg-light border rounded"><?php echo is_string($data) ? $data : htmlspecialchars((string)$data); ?></div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="alert alert-warning">Sin datos para mostrar.</div>
<?php endif; ?>