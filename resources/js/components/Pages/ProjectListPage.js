import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import Grid from '@mui/material/Grid';
import ProjectCard from '../Organisms/ProjectCard';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
`;

const ProjectListPage = () => {
  const [host, setHost] = useState('');
  const [projects, setProjects] = useState([]);

  useEffect(()=> {
    setHost(location.host);
  }, [])

  useEffect(() => {
    if (host) {
      let url = `http://${host}/api/all_projejct` // ここのエンドポイントは適当だから検討
      try {
        axios.get(url).then(res => {
          setProjects(res.data);
        });
      } catch (e) {
        console.error(e);
      }
    }
  }, [host])

  return (
    <ContainerGrid>
      {
        projects.length > 0 &&
          projects.map((project, index) => {
            return (
              <ProjectCard
                key={index}
                project_data={project}
              />
            );
          })

      }
    </ContainerGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
