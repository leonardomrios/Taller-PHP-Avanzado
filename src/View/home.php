<?php $sampleEmployees = json_encode([
  ['name' => 'Ana', 'salary' => 4500000, 'department' => 'TI'],
  ['name' => 'Luis', 'salary' => 3800000, 'department' => 'TI'],
  ['name' => 'Marta', 'salary' => 5200000, 'department' => 'Ventas'],
  ['name' => 'Sofía', 'salary' => 5100000, 'department' => 'Ventas'],
  ['name' => 'Pedro', 'salary' => 3000000, 'department' => 'Ops'],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$sampleSales = json_encode([
  ['id'=>'V001','client'=>'Acme','product'=>'Teclado','qty'=>3,'unit_price'=>80000,'date'=>'2025-08-01'],
  ['id'=>'V002','client'=>'Acme','product'=>'Mouse','qty'=>5,'unit_price'=>40000,'date'=>'2025-08-02'],
  ['id'=>'V003','client'=>'Globex','product'=>'Teclado','qty'=>7,'unit_price'=>79000,'date'=>'2025-08-03'],
  ['id'=>'V004','client'=>'Initech','product'=>'Monitor','qty'=>2,'unit_price'=>600000,'date'=>'2025-08-05'],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>
<h3 class="mb-3">Captura de datos</h3>
<div class="row g-4">
  <div class="col-lg-6">
    <h5>Empleados</h5>
    <form method="post" action="?action=processEmployees">
      <div class="mb-2">
        <label class="form-label">JSON de empleados</label>
        <textarea class="form-control" name="employees_json" rows="10"><?= htmlspecialchars($sampleEmployees) ?></textarea>
        <div class="form-text">Formato: name, salary, department</div>
      </div>
      <button class="btn btn-primary">Procesar empleados</button>
    </form>
  </div>
  <div class="col-lg-6">
    <h5>Ventas</h5>
    <form method="post" action="?action=processSales">
      <div class="mb-2">
        <label class="form-label">JSON de ventas</label>
        <textarea class="form-control" name="sales_json" rows="10"><?= htmlspecialchars($sampleSales) ?></textarea>
        <div class="form-text">Formato: id, client, product, qty, unit_price, date</div>
      </div>
      <button class="btn btn-success">Procesar ventas</button>
    </form>
  </div>
</div>
<hr class="my-4"/>
<h3 class="mb-3">Herramientas matemáticas</h3>
<div class="row g-4">
  <div class="col-md-4">
    <div class="border rounded p-3 h-100">
      <h6>Interés compuesto</h6>
      <form method="post" action="?action=math">
        <input type="hidden" name="tool" value="ci"/>
        <div class="mb-2"><label class="form-label">Principal</label><input class="form-control" name="ci_principal" type="number" step="0.01" value="1000000"></div>
        <div class="mb-2"><label class="form-label">Tasa anual (0-1)</label><input class="form-control" name="ci_rate" type="number" step="0.0001" value="0.12"></div>
        <div class="mb-2"><label class="form-label">Años</label><input class="form-control" name="ci_years" type="number" value="3"></div>
        <div class="mb-2"><label class="form-label">n (comp/ año)</label><input class="form-control" name="ci_n" type="number" value="12"></div>
        <button class="btn btn-outline-primary w-100">Calcular</button>
      </form>
    </div>
  </div>
  <div class="col-md-4">
    <div class="border rounded p-3 h-100">
      <h6>Salario neto (CO – simplificado)</h6>
      <form method="post" action="?action=math">
        <input type="hidden" name="tool" value="netco"/>
        <div class="mb-2"><label class="form-label">Salario bruto (COP)</label><input class="form-control" name="col_gross" type="number" step="0.01" value="3000000"></div>
        <button class="btn btn-outline-secondary w-100">Calcular</button>
      </form>
      <small class="text-muted">Incluye 4% salud + 4% pensión. Puedes ampliar reglas según tu caso.</small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="border rounded p-3 h-100">
      <h6>Conversión</h6>
      <form method="post" action="?action=math">
        <div class="mb-2">
          <label class="form-label">Tipo</label>
          <select class="form-select" name="conv_type">
            <option value="c2f">Celsius → Fahrenheit</option>
            <option value="kmh2ms">km/h → m/s</option>
          </select>
        </div>
        <div class="mb-2"><label class="form-label">Valor</label><input class="form-control" name="conv_value" type="number" step="0.01" value="100"></div>
        <button class="btn btn-outline-dark w-100">Convertir</button>
      </form>
    </div>
  </div>
</div>
<hr class="my-4"/>
<h3 class="mb-3">Extras (Composer)</h3>
<div class="row g-4">
  <div class="col-md-6">
    <div class="border rounded p-3 h-100">
      <h6>Subir imagen (Intervention Image)</h6>
      <form method="post" action="?action=image" enctype="multipart/form-data">
        <input class="form-control mb-2" type="file" name="photo" accept="image/*" required>
        <button class="btn btn-warning">Procesar imagen</button>
      </form>
    </div>
  </div>
  <div class="col-md-6">
    <div class="border rounded p-3 h-100">
      <h6>Enviar correo (Symfony Mailer)</h6>
      <form method="post" action="?action=mail">
        <div class="mb-2"><label class="form-label">Destinatario</label><input class="form-control" type="email" name="to" placeholder="tucorreo@example.com"></div>
        <button class="btn btn-info">Enviar prueba</button>
      </form>
      <small class="text-muted">Configura SMTP_DSN en tu entorno o en config.php.</small>
    </div>
  </div>
</div>