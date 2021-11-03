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
  const [searchGender, setSearchGender] = useState('');
  const [projects, setProjects] = useState([]);
  const [filterResult, setFilterResult] = useState([]);

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
    let result = [];

    projects.map((pj) => {
      if (searchLanguage.length > 0) {
        if (searchLanguage.includes(pj.language) || searchLanguage.includes(pj.sub_language)) result.push(pj);
      }
      if (searchPurpose !== 'すべて' && searchPurpose !== '') {
        if (searchPurpose === pj.purpose) result.push(pj);
      }
      if (searchGender !== '制限なし' && searchGender !== '') {
        if (searchGender === pj.men_and_women) result.push(pj);
      }
    })

    setFilterResult(result);
  }, [projects, searchLanguage, searchPurpose, searchGender])

  return (
    <WrapperGrid>
      <FilterContainer
        searchLanguage={searchLanguage}
        setSearchLanguage={(val) => setSearchLanguage(val)}
        searchPurpose={searchPurpose}
        setSearchPurpose={(val) => setSearchPurpose(val)}
        searchGender={searchGender}
        setSearchGender={(val) => setSearchGender(val)}
      />
      <ContainerGrid container justifyContent="center">
        {
          filterResult.length > 0 ? (
            filterResult.map((project, index) => {
              return <ProjectCard item key={index} project_data={project} />
            })
          ) : (
            projects.length > 0 &&
              projects.map((project, index) => {
                return <ProjectCard item key={index} project_data={project} />
              })
          )
        }
      </ContainerGrid>
    </WrapperGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
