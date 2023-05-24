const baseUrl = import.meta.env.VITE_BASE_URL + '/api/tarefas';

const req = async (url: string, method: string, data?: any) => {
  const headers = {
    'Content-Type': 'application/json'
  };

  const options: RequestInit = {
    method: method,
    headers: headers
  };

  if (data) {
    options.body = JSON.stringify(data);
  }

  const response = await fetch(url, options);
  
    return await response.json();
};

export default {
  getTarefas() {
    return req(baseUrl, 'GET');
  },
  getTarefa(id: number) {
    return req(`${baseUrl}/${id}`, 'GET');
  },
  adicionarTarefa(tarefa: any) {
    return req(baseUrl, 'POST', tarefa);
  },
  atualizarTarefa(id: number, tarefa: any) {
    return req(`${baseUrl}/${id}`, 'PUT', tarefa);
  },
  excluirTarefa(id: number) {
    return req(`${baseUrl}/${id}`, 'DELETE');
  }
};
