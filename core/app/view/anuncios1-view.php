  <section class="content" style="padding:20px;">
    <h2>Listado de anuncios</h2>

    <form method="GET" class="form-inline" style="margin-bottom:15px;">
      <select name="tipo" class="form-control">
        <option value="">Todos los tipos</option>
        <option value="noticia" <?= $filterTipo==='noticia'?'selected':''; ?>>Noticia</option>
        <option value="servicio" <?= $filterTipo==='servicio'?'selected':''; ?>>Servicio</option>
      </select>
      <input type="text" name="q" class="form-control" placeholder="Buscar título o cuerpo" value="<?= htmlspecialchars($search); ?>">
      <button type="submit" class="btn btn-default">Filtrar</button>
      <a href="crear.php" class="btn btn-success" style="margin-left:auto;">Nuevo anuncio</a>
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th><th>Título</th><th>Tipo</th><th>Fecha</th><th>Autor</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($anuncios as $a): ?>
        <tr>
          <td><?= $a['id']; ?></td>
          <td><?= htmlspecialchars($a['title']); ?></td>
          <td><?= htmlspecialchars($a['type']); ?></td>
          <td><?= htmlspecialchars($a['date']); ?></td>
          <td><?= htmlspecialchars($a['created_by'] ?? ''); ?></td>
          <td>
            <a href="editar.php?id=<?= $a['id']; ?>" class="btn btn-xs btn-primary">Editar</a>
            <a href="eliminar.php?id=<?= $a['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Eliminar anuncio?');">Eliminar</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>