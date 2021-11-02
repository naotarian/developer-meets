import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import _ from 'lodash'
import Grid from '@mui/material/Grid';
import ProjectCard from '../Organisms/ProjectCard';
import FilterContainer from '../Organisms/FilterContainer';

const WrapperGrid = styled(Grid)`
  width: 100%;
`;

const ContainerGrid = styled(Grid)`
  width: 70% !important;
  margin: auto;
`;

const ProjectListPage = () => {
  const [host, setHost] = useState('');
  const [searchLanguage, setSearchLanguage] = useState([]);
  const [searchPurpose, setSearchPurpose] = useState('');
  const [projects, setProjects] = useState([]);

  useEffect(() => {
    setHost(location.host);
  }, [])

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let url = `${protocol}://${host}/api/all_projejct`;
      axios.get(url).then(res => {
        setProjects(res.data);
      });
    }
  }, [host])

  useEffect(() => {
    console.log('発火！！！')
    if (searchLanguage) {
      console.log('言語でフィルターをかけます')
    }
    if (searchPurpose) {
      console.log('目的でフィルターをかけます')
    }

  }, [searchLanguage, searchPurpose])

  return (
    <WrapperGrid>
      <FilterContainer
        searchLanguage={searchLanguage}
        setSearchLanguage={(val) => setSearchLanguage(val)}
        searchPurpose={searchPurpose}
        setSearchPurpose={(val) => setSearchPurpose(val)}
      />
      <ContainerGrid container justifyContent="center">
        {
          projects.length > 0 &&
            projects.map((project, index) => {
              if (searchLanguage.length > 0) {
                if (searchLanguage.includes(project.language) || searchLanguage.includes(project.sub_language)) {
                  return <ProjectCard item key={index} project_data={project} />
                }
              } else {
                return <ProjectCard item key={index} project_data={project} />
              }
            })
        }
      </ContainerGrid>
    </WrapperGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
